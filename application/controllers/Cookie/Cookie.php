<?php
namespace application\controllers\Cookie;

use application\controllers\Match\Match;

class Cookie
{
    public static function setCookie(string $email, string $password)
    {
        setcookie(
            'email',
            $email,
            strtotime("+30 days"),
            "/",
            'frisbee'
            //            '62.113.98.197'
        );

        setcookie(
            'password',
            $password,
            strtotime("+30 days"),
            "/",
            'frisbee'
            //            '62.113.98.197'
        );
    }

    //delete public after all tests be done
    public static function purgeCookie()
    {
        setcookie(
            'password',
            'none',
            time() - 3600
        );

        setcookie(
            'email',
            'none',
            time() - 3600
        );
    }


    public static function cookieIsset(): bool
    {
        if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
            if (Match::cookiesMatchData($_COOKIE['email'], $_COOKIE['password'])) {
                return true;
            } else {
                Cookie::purgeCookie();
                return false;
            }
        } else {
            return false;
        }
    }
}
