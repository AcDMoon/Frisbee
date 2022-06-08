<?php

namespace Frisbee\controllers\LoginController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\views\LoginView\LoginView;

class LoginController
{
    private static function authorize(string $email, string $password, string $destination)
    {
        $warnings = Authorization::authorization($email, $password);
        if (is_null($warnings)) {
            Cookie::setCookie($email, $password);

            if ($destination) {
                $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
                header("Location: http://" . $domain['domain'] . "/" . $destination);
                exit();
            }
            $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        } else {
            LoginView::renderLoginPage($warnings, $destination);
        }
    }

    private static function buttonIsPush(string $email, string $password, string $destination, bool $push)
    {
        if ($push) {
            self::authorize($email, $password, $destination);
        } else {
            LoginView::renderLoginPage([], $destination);
        }
    }

    private static function cookieIsset(string $destination)
    {
        if (VerificationController::cookieVerification()) {
            if (!$destination) {
                $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
                header("Location: http://" . $domain['domain'] . "/Profile");
                exit();
            } else {
                $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
                header("Location: http://" . $domain['domain'] . "/" . $destination);
                exit();
            }
        }
    }

    public static function login(string $email, string $password, string $destination, bool $push)
    {
        self::cookieIsset($destination);
        self::buttonIsPush($email, $password, $destination, $push);
    }

    public static function logout()
    {
        Cookie::purgeCookie();
        $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
        header("Location: http://" . $domain['domain'] . "/login");
        exit();
    }
}
