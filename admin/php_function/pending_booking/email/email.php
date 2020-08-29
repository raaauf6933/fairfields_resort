<?php
require("PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/src/SMTP.php");
require("PHPMailer-master/src/Exception.php");


$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP();

$mail->CharSet = "UTF-8";
$mail->Host = "smtp.gmail.com";
$mail->SMTPDebug = 1;
$mail->Port = 465; //465 or 587

$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->IsHTML(true);

//Authentication
$mail->Username = "crackersh323@gmail.com";
$mail->Password = "Hansel2020";

//Set Params
$mail->SetFrom("crackersh323@gmail.com");
$mail->AddAddress("fairfieldsresort2020@gmail.com");
$mail->Subject = "Test";
$mail->Body = "<h1>HELLO</h1>";


if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message has been sent";
}
?>