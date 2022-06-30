<?php

namespace Frisbee\controllers\Cookie;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

class Cookie
{
    public static function setCookie(string $email, string $password)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
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
