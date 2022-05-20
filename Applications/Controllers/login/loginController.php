<?php
namespace Applications\Controllers\login;

use Applications\Controllers\matchOperations\Match;
use Applications\Controllers\cookie\Cookie;

class loginController
{

    private static function authorize(string $email, string $password, string $destination=''){
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
            if ($destination){
                $destination = '?destination='.$destination;
            }
            require __DIR__ . '/../../Views/login.php';
        }
    }


    private static function userWithoutDestination(string $email, string $password){
        if ($_COOKIE['email'] and $_COOKIE['password']) {
            self::userWithCookie();
        }

        self::authorize($email, $password);
    }


    private static function userWithCookie(){
        if (Match::cookiesMatchData($_COOKIE['email'], $_COOKIE['password'])){
            header("Location: http://frisbee/profile");
            exit();
        }
        Cookie::purgeCookie($_COOKIE['email'], $_COOKIE['password']);
    }







    //Если редирект со страницы профиля - значит кук небыло или они не совпали и их удалило - на куки проверять не надо
    public static function loginRouter(string $email, string $password, string $destination){
        if ($destination){
            self::authorize($email, $password, $destination);

        }else {
            self::userWithoutDestination($email, $password);
        }
    }

}