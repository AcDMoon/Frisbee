<?php
namespace Applications\Controllers\login;

use Applications\Controllers\matchOperations\Match;
use Applications\Controllers\cookie\Cookie;

class loginController
{

    private static function userWithCookie(){
        if (Match::cookiesMatchData($_COOKIE['email'], $_COOKIE['password'])){
            header("Location: http://frisbee/profile");
            exit();
        }
        Cookie::purgeCookie($_COOKIE['email'], $_COOKIE['password']);
    }


    private static function userWithoutDestination(string $email, string $password){
        if ($_COOKIE['email'] and $_COOKIE['password']) {
            self::userWithCookie();
        }

        if (!$_POST['email'] and !$_POST['password']){

        }

        $warnings= Authorization::authorization($email, $password);
        if (is_null($warnings)){
            Cookie::setCookie($email, $password);
            header("Location: http://frisbee/profile");
        }else{
            require __DIR__ . '/../../Views/login.php';
        }
    }


    private static function userWithDestination(){}


    public static function loginRouter(string $email='', string $password=''){
        if ($_GET['destination']){
            self::userWithDestination();

        }else {self::userWithoutDestination($email, $password);}
    }

}