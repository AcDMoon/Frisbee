<?php

namespace application\controllers\SignupController;

use application\controllers\VerificationController\VerificationController;
use application\views\SignupView\SignupView;

class SignupController
{
    private static function cookieCheck()
    {
        if (VerificationController::cookieVerification()) {
            $domain = require 'application/config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }
    }


    public static function signup(string $email, string $password, string $name, string $date, bool $push)
    {
        self::cookieCheck();

        if (!$push) {
            SignupView::renderSignupPage([]);
            exit();
        }

        $warnings = Registration::registrationProcedures($email, $password, $name, $date);

        if (is_null($warnings)) {
            $domain = require 'application/config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/EmailConfirm");
            exit();
        } else {
            SignupView::renderSignupPage($warnings);
            exit();
        }
    }
}
