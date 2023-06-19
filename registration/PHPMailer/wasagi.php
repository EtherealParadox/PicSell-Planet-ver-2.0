<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try{
    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host = 'smtp.mail.yahoo.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'picsellplanet@yahoo.com';
    $mail->Password = 'nvvnqmgjotyqaiqk';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('picsellplanet@yahoo.com', 'PicSellPlanet');

    $mail->addAddress('picsellplanet@yahoo.com');

    $body = '<p><strong> This is my first email with PHPMailer</p>';


    $mail->isHTML(true);
    $mail->Subject = 'Test Email';

    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo 'Message has been sent';


}catch(Exception $e){
    echo 'Message has not been sent';
    echo 'Mailer error: ' . $mail->ErrorInfo;
}
