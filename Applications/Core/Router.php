<?php

namespace Applications\Core;

use Applications\Controllers\cookie\Cookie;
use Applications\Controllers\login\Authorization;
use Applications\Controllers\login\loginController;
use Applications\Controllers\matchOperations\Match;
use Applications\Controllers\signup\Registration;


class Router
{
    private static $routes = array();
    // запрещаем создание и копирование статического объекта
    private function __construct() {}
    private function __clone() {}

    public static function route($pattern, $callback)
    {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/iu';
        self::$routes[$pattern] = $callback;
    }

    public static function execute($url)
    {
        foreach (self::$routes as $pattern => $callback)
        {
            if (preg_match($pattern, $url, $params))
            {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }
}


Router::route('/AboutUs(/{0,1})', function(){
    require "Applications/Views/AboutUs/About us.php";;
});

Router::route('/Support(/{0,1})', function(){
    require "Applications/Views/Support/Support.php";;
});

Router::route('/Donation(/{0,1})', function(){
    require "Applications/Views/Donation/Donation.php";;
});

Router::route('/SignUp(/{0,1})', function(){
    if (!$_POST['E-mail'] and !$_POST['password'] and !$_POST['name'] and !$_POST['date_of_birth']){
        require "Applications/Views/signup.php";
    }else{
        $result = Registration::reg($_POST['E-mail'], $_POST['password'], $_POST['name'],$_POST['date_of_birth']);
        if (is_null($result)){
            require __DIR__ . '/../Views/login.php';
        }else {
            require __DIR__ . '/../Views/signup.php';
        }
    }

});

Router::route('/LogIn(/{0,1})', function(){
//    Cookie::purgeCookie($_COOKIE['email'], $_COOKIE['password']);
    loginController::loginRouter($_POST['email'], $_POST['password']);
});

Router::route('/', function(){
    require "Applications/Views/MainPage/Main page mobile.php";;
});

Router::route('/profile(/{0,1})', function(){
    require "Applications/Views/Profile/Profile.php";;
});

Router::route('/Group(/{0,1})', function(){
    require "Applications/Views/GrouPage/Group page.php";;
});




Router::route('/test(/{0,1})', function(){
    require "Applications/Controllers/CookieMatch.php";;
});