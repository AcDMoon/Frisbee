<?php

namespace Applications\core;

class Router
{
    private static $routes = array();
    // запрещаем создание и копирование статического объекта
    private function __construct() {}
    private function __clone() {}

    public static function route($pattern, $callback)
    {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
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
    require "Applications/Vievs/AboutUs/About us.php";;
});

Router::route('/Support(/{0,1})', function(){
    require "Applications/Vievs/Support/Support.php";;
});

Router::route('/Donation(/{0,1})', function(){
    require "Applications/Vievs/Donation/Donation.php";;
});

Router::route('/SignUp(/{0,1})', function(){
    require "Applications/Vievs/SignUp/Sign up.php";;
});

Router::route('/LogIn(/{0,1})', function(){
    require "Applications/Vievs/LogIn/Log in.php";;
});

Router::route('/', function(){
    require "Applications/Vievs/MainPage/Main page mobile.php";;
});

Router::route('/signup(/{0,1})', function(){
    require "Applications/Vievs/SignUp/signup.php";;
});


Router::route('/SignupController(/{0,1})', function(){
    require "Applications/Vievs/SignUp/SignupController.php";;
});