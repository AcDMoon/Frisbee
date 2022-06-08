<?php

namespace Frisbee\controllers\RestorePasswordController;

use Frisbee\controllers\Mailer\Mailer;
use Frisbee\core\model\DB;
use Frisbee\views\RestorePasswordView\RestorePasswordView;

class RestorePasswordController
{
    private static function mailCheckProcedure($email)
    {
        if (DB::emailIsset($email)) {
            $hash = md5($email . time() . rand(100000, 999999));
            DB::setHash($email, $hash);
            $title = 'Frisbee - Restore password';
            $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
            $content = '<a href="http://' . $domain['domain'] . '/restore?hash=' . $hash . '">To restore, click this</a>';
            Mailer::sendMessage($email, $title, $content);
            header("Location: http://" . $domain['domain'] . "/EmailConfirm");
            exit();
        } else {
            $emailWarnings = 'No such email found';
            RestorePasswordView::renderRestorePage(['email' => $email,'emailWarnings' => $emailWarnings]);
        }
    }


    private static function hashIsCorrect($hash)
    {
        $emailFromHash = DB::getEmailFromHash($hash);
        if ($emailFromHash) {
            DB::deleteHash($hash);
            RestorePasswordView::renderRestorePage(['emailFromHash' => $emailFromHash]);
        } else {
            $domain = require 'application/config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/restore");
        }
    }


    private static function passwordReset($emailFromHash, $password)
    {
        DB::resetUserPassword($emailFromHash, $password);
        $domain = require 'application/config/validDomain.php';
        header("Location: http://" . $domain['domain'] . "/login");
    }


    public static function passwordResetNavigator($email, $emailFromHash, $password, $hash, $buttonIsPush)
    {
        if ($hash) {
            self::hashIsCorrect($hash);
            return;
        }

        if ($emailFromHash && $password) {
            self::passwordReset($emailFromHash, $password);
            return;
        }

        if ($email) {
            self::mailCheckProcedure($email);
            return;
        }

        if ($buttonIsPush) {
            $emailWarnings = 'Blank field!';
            RestorePasswordView::renderRestorePage(['email' => $email,'emailWarnings' => $emailWarnings]);
            return;
        }

        RestorePasswordView::renderRestorePage();
    }
}
