<?php 

    // Check login state
    require("../../res/php/session.php");
    start_session();
    require("../../res/php/checkLogin.php");
    if(!checkLogin()) header("Location: /account");

    // Get config
    require("../../config.php");

    // DB Connection
    $con = mysqli_connect(
        config_db_host,
        config_db_user,
        config_db_password,
        config_db_name
    );
    if(mysqli_connect_errno()) die("Error with the Database");

    // Get input
    $className = $_POST["className"];
    $testCustom = $_POST["testCustom"];
    $gradingTypeK = $_POST["gradingTypeK"];
    $gradingTypeM = $_POST["gradingTypeM"];
    $gradingTypeT = $_POST["gradingTypeT"];
    $gradingTypeS = $_POST["gradingTypeS"];
    $classColor = $_POST["classColor"];
    $classID = $_POST["classID"];

    // Check if necessary input is given
    if(!isset($className) || strlen($className) == 0) die("missing-classname");
    if(!isset($testCustom)) die("missing-testcustom");
    if(!isset($gradingTypeK)) die("missing-gradingtypeK");
    if(!isset($gradingTypeM)) die("missing-gradingtypeM");
    if($testCustom == "true" && !isset($gradingTypeT)) die("missing-gradingtypeT");
    if(!isset($gradingTypeS)) die("missing-gradingtypeS");
    if(!isset($classColor)) die("missing-classcolor");
    if(!isset($classID)) die("missing-classid");

    // Check if class exists and belongs to user
    if ($stmt = $con->prepare('SELECT user_id FROM '.config_table_name_classes.' WHERE id = ?')) {
        $stmt->bind_param('i', $classID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userID);
        $stmt->fetch();
        if($userID !== $_SESSION["user_id"]) die("missing-class");
        $stmt->close();
    } else die("Error with the Database");

    // Generate gradeTypeT if not custom
    if($testCustom == "false") $gradingTypeT = "1exam";
    else $gradingTypeT = strval($gradingTypeT);

    // Remove # from color
    $classColor = str_replace("#", "", $classColor);

    // Make an sql statement to update the class
    // exit("UPDATE ".config_table_name_classes." SET name = '".$className."', color = '".$classColor."', grade_k = ".$gradingTypeK.", grade_m = ".$gradingTypeM.", grade_t = '".$gradingTypeT."', grade_s = ".$gradingTypeS." WHERE id = ".$classID);

    // Update class in DB
    if ($stmt = $con->prepare('UPDATE '.config_table_name_classes.' SET name = ?, color = ?, grade_k = ?, grade_m = ?, grade_t = ?, grade_s = ? WHERE id = ?')) {
        $stmt->bind_param('ssiisii', $className, $classColor, $gradingTypeK, $gradingTypeM, $gradingTypeT, $gradingTypeS, $classID);
        $stmt->execute();
        $stmt->close();
        exit("success");
    } else die("Error with the Database");

    // DB Con close
    $con->close();
?>