<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

function sendmail($to_mail, $body_html, $body_text, $subject)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.365homes.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mail@365homes.net';                 // SMTP username
        $mail->Password = 'secret0@mail!';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('mail@365homes.net', '365homes.net');

        $recipients = explode(";", $to_mail);

        foreach($recipients as $rcv) {
            $mail->addAddress($rcv, $rcv);
        }

        //$mail->addAddress($to_mail, $to_mail);     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body_html;
        $mail->AltBody = $body_text;

        $r = $mail->send();

        return $r;
    } catch (Exception $e) {
        throw $e;
    }
}
