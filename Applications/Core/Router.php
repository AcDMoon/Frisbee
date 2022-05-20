<?php

namespace Applications\Core;

use Applications\Controllers\login\Authorization;
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
        $result = Registration::Reg($_POST['E-mail'], $_POST['password'], $_POST['name'],$_POST['date_of_birth']);
        if (is_null($result)){
            require __DIR__ . '/../Views/login.php';
        }else {
            require __DIR__ . '/../Views/signup.php';
        }
    }

});

Router::route('/LogIn(/{0,1})', function(){
    if (!$_POST['email'] and !$_POST['password']){
        require "Applications/Views/login.php";
    }else{
        $result = Authorization::authorization($_POST['email'], $_POST['password']);
        if (is_null($result)){
            require __DIR__ . '/../Views/Profile/Profile.php';
        }else {
            require __DIR__ . '/../Views/login.php';
        }
    }

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




