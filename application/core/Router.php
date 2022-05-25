<?php

namespace application\core;

use application\controllers\AboutUsController\AboutUsController;
use application\controllers\DonationController\DonationController;
use application\controllers\LoginController\LoginController;
use application\controllers\MainPageController\MainPageController;
use application\controllers\ProfileController\ProfileController;
use application\controllers\SignupController\SignupController;
use application\controllers\SupportController\SupportController;
use application\controllers\test\test;

class Router
{
    private static $routes = array();
    // запрещаем создание и копирование статического объекта
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function route($pattern, $callback)
    {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/iu';
        self::$routes[$pattern] = $callback;
    }

    public static function execute($url)
    {
        foreach (self::$routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }
}


Router::route('/AboutUs(/{0,1})', function () {
    AboutUsController::aboutUs();
});

Router::route('/Support(/{0,1})', function () {
    SupportController::support();
});

Router::route('/Donation(/{0,1})', function () {
    DonationController::donation();
});

Router::route('/SignUp(/{0,1})', function () {

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = '';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = '';
    }

    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    } else {
        $date = '';
    }

    if (isset($_POST['push'])) {
        $push = $_POST['push'];
    } else {
        $push =false;
    }

    SignupController::signup($email, $password, $name, $date, $push);
});

Router::route('/LogIn(/{0,1})', function () {


    if (isset($_GET['destination'])) {
        $destination = $_GET['destination'];
    } else {
        $destination = '';
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = '';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }


    if (isset($_POST['push'])) {
        $push = $_POST['push'];
    } else {
        $push =false;
    }

    LoginController::login($email, $password, $destination, $push);
});

Router::route('/', function () {
    MainPageController::mainPage();
});

Router::route('/Profile(/{0,1})', function () {
    ProfileController::profile();
});

Router::route('/Group(/{0,1})', function () {
    require "application/views/group-page/group-page.php";
});

Router::route('/logout(/{0,1})', function () {
    LoginController::logout();
});




Router::route('/test(/{0,1})', function () {
    test::destroyCookie();
});
