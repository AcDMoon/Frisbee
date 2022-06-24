<?php

namespace Frisbee\controllers\Mailer;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use PHPMailer\PHPMailer\PHPMailer;

require $GLOBALS['base_dir'] . 'lib/PHPMailer-master/src/Exception.php';
require $GLOBALS['base_dir'] . 'lib/PHPMailer-master/src/PHPMailer.php';
require $GLOBALS['base_dir'] . 'lib/PHPMailer-master/src/SMTP.php';

class Mailer
{
    public static function sendMessage($email, $title, $content)
    {
        $mailerConfig = IncludeOrRequireMethods::requireConfig('mailer.php');
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->Encoding   = '8bit';
        $mail->SMTPSecure = 'ssl';
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

