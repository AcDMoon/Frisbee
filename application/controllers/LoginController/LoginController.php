<?php
namespace application\controllers\LoginController;

use application\controllers\Cookie\Cookie;
use application\views\LoginView\LoginView;

class LoginController
{

    private static function authorize(string $email, string $password, string $destination)
    {
        $warnings= Authorization::authorization($email, $password);
        if (is_null($warnings)) {
            Cookie::setCookie($email, $password);

            if ($destination) {
//                header("Location: http://62.113.98.197/".$destination);
                header("Location: http://frisbee/".$destination);
                exit();
            }
//            header("Location: http://62.113.98.197/profile");
            header("Location: http://frisbee/Profile");
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
        if (Cookie::cookieIsset()) {
            if (!$destination) {
//                header("Location: http://62.113.98.197/profile");
                header("Location: http://frisbee/Profile");
                exit();
            } else {
//                header("Location: http://62.113.98.197/".$destination);
                header("Location: http://frisbee/".$destination);
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
//        header("Location: http://http:/62.113.98.197//log-in");
        header("Location: http://frisbee/login");
        exit();
    }
}
