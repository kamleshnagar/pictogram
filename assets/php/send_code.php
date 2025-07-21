<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

function sendCode($email,$subject,$code){
global $mail;









try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Change to 2 for debugging
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kaalmusicproduction@gmail.com';       // Your Gmail address
    $mail->Password   = 'lqdq iule ynsg qbvd';        // App password, NOT your real password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    
    //Recipients
    $mail->setFrom('kaalmusicproduction@gmail.com', 'Pictogram');
    $mail->addAddress($email);
    
    //Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = 'This is a test email with <b>'.$code.'</b>';
    

    $mail->send();
    echo 'messager sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}