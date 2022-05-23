<?php

namespace Applications\Controllers\signup;

use Applications\Controllers\cookie\Cookie;
use Applications\Controllers\matchOperations\Match;

class signupController
{
    private static function cookieIsset(){
        if (Cookie::cookieIsset()){
            header("Location: http://frisbee/profile");
            exit();
        }
    }


    public static function signup(string $email, string $password, string $name, string $date, bool $push){
        self::cookieIsset();

        if (!$push){
            require __DIR__."/../../Views/signup.php";
            exit();
        }

        $warnings = Registration::reg($email, $password, $name, $date);

        if (is_null($warnings)){
            header("Location: http://frisbee/login");
            exit();
        }else {
            require __DIR__."/../../Views/signup.php";
            exit();
        }
    }




}