<?php

namespace application\controllers\Cookie;

class Cookie
{
    public static function setCookie(string $email, string $password)
    {
        $domain = require 'application/config/validDomain.php';
        setcookie(
            'email',
            $email,
            strtotime("+30 days"),
            "/",
            $domain['domain']
        );

        setcookie(
            'password',
            $password,
            strtotime("+30 days"),
            "/",
            $domain['domain']
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
}
