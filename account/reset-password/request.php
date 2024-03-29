<?php
//Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../../res/php/PHPMailer-master/src/Exception.php';
require '../../res/php/PHPMailer-master/src/PHPMailer.php';
require '../../res/php/PHPMailer-master/src/SMTP.php';

// Load config
require '../../config.php';

// Input
$email = $_POST['mail'];

// Conect to database
$con = mysqli_connect(config_db_host, config_db_user, config_db_password, config_db_name);
if (mysqli_connect_errno()) exit("Error connecting to our database! Please try again later."); 

// Check if account exists
$stmt = $con->prepare("SELECT id, displayname FROM ".config_table_name_accounts." WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows != 1) exit("Account not found! | Could also be that there are multiple accounts with the same email address!");
$stmt->bind_result($id, $displayname);
$stmt->fetch();
$stmt->close();

// Create 8 digit password using Chars 0-9 A-Z a-z !"$%&/+*~-_#
$password = "";
for ($i = 0; $i < 8; $i++) {
    $password .= substr("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!\"$&/+*~-_#", mt_rand(0, 71), 1);
}

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Update password
$stmt = $con->prepare("UPDATE ".config_table_name_accounts." SET password = ?, account_version = 3 WHERE id = ?");
$stmt->bind_param('ss', $hash, $id);
$stmt->execute();
$stmt->close();

// Create an instance of PHPMailer
$mail = new PHPMailer();

try {
    // Server settings
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      	//Enable verbose debug output
    $mail->isSMTP();                                            	//Send using SMTP
    $mail->Host       = config_mail_host;                     	    //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   	//Enable SMTP authentication
    $mail->Username   = config_mail_username;                       //SMTP username
    $mail->Password   = config_mail_password;                       //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            	//Enable implicit TLS encryption
    $mail->Port       = 465;                                    	//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom(config_mail_sender_mail, config_mail_sender_name);
    $mail->addAddress($email, $displayname);                         //Add a recipient

    // Content
    $mail->isHTML(true);                                            //Set email format to HTML
    $mail->Subject = 'Login Reset';
    $mail->Body    = 'Someone requested that the password be reset for the following Noten-App.de Account:<br>Username: <b>'.$displayname.'</b><br>If this was a mistake, just ignore this email and nothing will happen.<br><br><br>Your new Password is: '.$password.'<br><p style="font-weight: bold;color:red;">Please change it inside the App</p><br><br>Thank You';
    $mail->AltBody = 'Someone requested that the password be reset for the following Noten-App.de Username: '.$displayname.'If this was a mistake, just ignore this email and nothing will happen.Your new Password is: '.$password.' Please change it in the app! Thank You';
	
	// Disable debugging
	$mail->SMTPDebug = false;

    // Send mail
    $mail->send();
    
    // Redirect to login
    header("Location: /");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>