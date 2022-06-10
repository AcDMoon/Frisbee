<?php

namespace Frisbee\controllers\SignupController;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\views\SignupView\SignupView;

class SignupController
{
    private static function postDataAvailability()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $date = $_POST['date'] ?? '';
        $push = $_POST['push'] ?? false;
        $postData = compact('email', 'password', 'name', 'date', 'push');
        return $postData;
    }


    private static function cookieCheck()
    {
        if (VerificationController::cookieVerification()) {
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }
    }


    public static function signup()
    {
        $postData = self::postDataAvailability();
        extract($postData);

        self::cookieCheck();

        if (!$push) {
            SignupView::renderSignupPage([]);
            exit();
        }

        $warnings = Registration::registrationProcedures($email, $password, $name, $date);

        if (!$warnings) {
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            header("Location: http://" . $domain['domain'] . "/EmailConfirm");
            exit();
        } else {
            SignupView::renderSignupPage($warnings);
            exit();
        }
    }
}
