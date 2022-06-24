<?php

namespace Frisbee\controllers\LoginController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\views\LoginView\LoginView;

class LoginController
{
    private static function convertPostAndGetToVariables()
    {
        $destination = $_GET['destination'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $push = $_POST['push'] ?? false;
        $postOrGetData = compact('destination', 'email', 'password', 'push');
        return $postOrGetData;
    }

    private static function authorize(string $email, string $password, string $destination)
    {
        $warnings = Authorization::authorization($email, $password);
        if (is_null($warnings)) {
            Cookie::setCookie($email, $password);

            if ($destination) {
                $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
                header("Location: http://" . $domain['domain'] . "/" . $destination);
                exit();
            }
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
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
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            if (!$destination) {
                header("Location: http://" . $domain['domain'] . "/Profile");
                exit();
            } else {
                header("Location: http://" . $domain['domain'] . "/" . $destination);
                exit();
            }
        }
    }

    public static function login()
    {
        $postOrGetData = self::convertPostAndGetToVariables();
        extract( $postOrGetData);

        self::cookieIsset($destination);
        self::buttonIsPush($email, $password, $destination, $push);
    }

    public static function logout()
    {
        Cookie::purgeCookie();
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        header("Location: http://" . $domain['domain'] . "/login");
        exit();
    }
}
