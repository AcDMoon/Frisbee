<?php
namespace Applications\Controllers\login;

use Applications\Controllers\matchOperations\Match;
use Applications\Controllers\cookie\Cookie;

class loginController
{

    private static function authorize(string $email, string $password, string $destination){
        $warnings= Authorization::authorization($email, $password);
        if (is_null($warnings)){
            Cookie::setCookie($email, $password);

            if ($destination){
                header("Location: http://frisbee/".$destination);
                exit();
            }

            header("Location: http://frisbee/profile");
            exit();

        }else{
            require __DIR__ . '/../../Views/login.php';
        }
    }

    private static function buttonIsPush(string $email, string $password, string $destination, bool $push){
        if ($push){
            self::authorize($email, $password, $destination);
        } else {
            require __DIR__."/../../Views/login.php";
        }

    }

    private static function cookieIsset(string $destination){
        if (Cookie::cookieIsset()){
            if (!$destination){
                header("Location: http://frisbee/profile");
                exit();
            }else {
                header("Location: http://frisbee/".$destination);
                exit();
            }
        }
    }

    public static function login(string $email, string $password, string $destination, bool $push){
        self::cookieIsset($destination);
        self::buttonIsPush($email, $password, $destination,$push);
    }

    public static function logout(){
        Cookie::purgeCookie();
        header("Location: http://frisbee/login");
        exit();
    }
}