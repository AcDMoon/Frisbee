<?php
namespace Applications\Controllers\cookie;



class Cookie
{
    public static function setCookie(string $email, string $password){
        setcookie(
            'email',
            $email,
            strtotime("+30 days"),
            "/",
            'frisbee'
        );

        setcookie(
            'password',
            $password,
            strtotime("+30 days"),
            "/",
            'frisbee'
        );
    }

    public static function purgeCookie(string $email, string $password){
        setcookie(
            'password',
            $email,
            time() - 3600
        );

        setcookie(
            'email',
            $password,
            time() - 3600,

        );
    }



}