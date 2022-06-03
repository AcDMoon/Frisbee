<?php
namespace application\controllers\Cookie;



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


}
