<?php

namespace application\controllers\SignupController;

use application\controllers\Cookie\Cookie;
use application\views\SignupView\SignupView;

class SignupController
{
    private static function cookieCheck()
    {
        if (Cookie::cookieIsset()) {
//            header("Location: http://62.113.98.197/profile");
            header("Location: http://frisbee/Profile");
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
//            header("Location: http://62.113.98.197/log-in");
//            header("Location: http://frisbee/login");
            header("Location: http://frisbee/EmailConfirm");
            exit();
        } else {
            SignupView::renderSignupPage($warnings);
            exit();
        }
    }
}
