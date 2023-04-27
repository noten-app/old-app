<?php 

    // Check login state
    session_start();
    require("../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

    // Get config
    require("../config.php");

    // DB Connection
    $con = mysqli_connect(
        config_db_host,
        config_db_user,
        config_db_password,
        config_db_name
    );
    if(mysqli_connect_errno()) exit("Error with the Database");

    // Get all classes
    $classlist = array();
    if($stmt = $con->prepare("SELECT name, color, id, last_used, average FROM ".config_table_name_classes." WHERE user_id = ? ORDER BY average ASC")) {
        $stmt->bind_param("s", $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->bind_result($class_name, $class_color, $class_id, $class_last_used, $class_grade_average);
        while ($stmt->fetch()) {
            $classlist[] = array(
                "name" => $class_name,
                "color" => $class_color,
                "id" => $class_id,
                "last_used" => $class_last_used,
                "average" => $class_grade_average
            );
        }
        $stmt->close();
    }

    // Create PDF
    require('../res/php/fpdf185/fpdf.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    // - - - - - - - //
    //    Header     //
    // - - - - - - - //
    $pdf->Image('../res/img/logo.png',10,6,20);
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(70);
    $pdf->Cell(60,10,'Noten-App.de - Export',0,0,'C');
    $pdf->Ln(20);

    // - - - - - - - //
    //    Grades     //
    // - - - - - - - //
    foreach ($classlist as $class) {
        // Class-Header
        $pdf->SetFont('Arial','B',15);
        if($class["average"] != 0) $title = $class["name"].' - '.iconv('utf-8', 'cp1252', 'Ø ').number_format($class["average"], $_SESSION["setting_rounding"], '.', '');
        else $title = $class["name"];
        $pdf->Cell(0,10,$title,0,0,'L');
        $pdf->Ln(7.5);
        $pdf->SetTextColor(0,0,0);
        // Table-Header
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(30,10,'Datum',1,0,'C');
        $pdf->Cell(20,10,'Note',1,0,'C');
        $pdf->Cell(40,10,'Art der Note',1,0,'C');
        $pdf->Cell(100,10,'Notiz',1,0,'C');
        $pdf->Ln();
        // Get grades
        $grades = array(); 
        if ($stmt = $con->prepare('SELECT id, user_id, class, note, type, date, grade FROM grades WHERE class = ?')) {
            $stmt->bind_param('s', $class["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            foreach($result as $row) {
                array_push($grades, $row);
            }
            $stmt->close();
        } else {
            exit("ERROR1");
        }
        $pdf->SetFont('Arial','',12);
        foreach ($grades as $grade) {
            $pdf->Cell(30,10,$grade["date"],1,0,'C');
            $pdf->Cell(20,10,$grade["grade"],1,0,'C');
            switch ($grade["type"]){
                case "k":
                    $grade["type"] = "Exam";
                    break;
                case "m":
                    $grade["type"] = "Oral";
                    break;
                case 's':
                    $grade["type"] = "Other";
                    break;
                case 't':
                    $grade["type"] = "Test";
                    break;
                default: 
                    $grade["type"] = "Unknown";
                    break;
                }
            $pdf->Cell(40,10,$grade["type"],1,0,'C');
            $pdf->Cell(100,10,iconv('utf-8', 'cp1252', $grade["note"]),1,0,'C');
            $pdf->Ln();
        }
        // Linebreak
        $pdf->Ln(5);
    }

    // DB Con close
    $con->close();

    // Output PDF
    $pdf->Output("d", "Export-".date("d_m_Y").".pdf");
?>