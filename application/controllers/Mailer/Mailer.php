<?php

namespace application\controllers\Mailer;

use PHPMailer\PHPMailer\PHPMailer;

require "vendor/autoload.php";

class Mailer
{
    public static function sendMessage($email, $title, $content)
    {
        $mailerConfig = require 'application/config/mailer.php';
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsHTML(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Host = 'ssl://smtp.yandex.ru';
        $mail->Port = 465;
        $mail->Username = $mailerConfig['mailerEmail'];
        $mail->Password = $mailerConfig['mailerPassword'];
        $mail->setFrom($mailerConfig['mailerEmail'], 'Frisbee');
        $mail->addAddress($email);
        $mail->Subject = $title;
        $body = $content;
        $mail->msgHTML($body);
        $mail->send();
    }
}
