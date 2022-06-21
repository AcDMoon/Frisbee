<?php

namespace Frisbee\controllers\RestorePasswordController;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\User\User;
use Frisbee\views\RestorePasswordView\RestorePasswordView;

class RestorePasswordController
{
    private static function postOrGetDataAvailability()
    {
        $hash = $_GET['hash'] ?? '';
        $email = $_POST['email'] ?? '';
        $emailFromHash = $_POST['emailFromHash'] ?? '';
        $password = $_POST['password'] ?? '';
        $buttonIsPush = $_POST['push'] ?? false;
        $postOrGetData = compact('hash', 'email', 'emailFromHash', 'password', 'buttonIsPush');
        return $postOrGetData;
    }


    private static function mailCheckProcedure($email)
    {
        $user = new User(['email' => $email]);
        $verification = $user-> getInfo(['verification'])[0];
        if ($verification) {
            $hash = md5($email . time() . rand(100000, 999999));
            $user = new User(['email' => $email, 'hash' => $hash]);
            $user->updateObject();
            $title = 'Frisbee - Restore password';
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            $content = '<p> Someone tried to restore password for an Frisbee account with '. $email .'. If it was you <a href="http://' . $domain['domain'] . '/restore?hash=' . $hash . '"> ,click this, to restore</a></p>';
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
        $user = new User(['hash' => $hash]);
        $userEmail = $user->getInfo(['email'])[0];
        if ($userEmail) {
            $user = new User(['hash' => '']);
            $user->updateObject();
            RestorePasswordView::renderRestorePage(['emailFromHash' => $userEmail]);
        } else {
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            header("Location: http://" . $domain['domain'] . "/restore");
        }
    }


    private static function passwordReset($emailFromHash, $password)
    {
        $user = new User(['email' => $emailFromHash, 'password' => $password]);
        $user->updateObject();
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        header("Location: http://" . $domain['domain'] . "/login");
    }


    public static function passwordResetNavigator()
    {
        $postOrGetData = self::postOrGetDataAvailability();
        extract($postOrGetData);


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
