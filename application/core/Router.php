<?php

namespace application\core;

use application\controllers\AboutUsController\AboutUsController;
use application\controllers\DonationController\DonationController;
use application\controllers\LoginController\LoginController;
use application\controllers\MainPageController\MainPageController;
use application\controllers\ProfileController\ProfileController;
use application\controllers\ProfileController\ProfileRedactor;
use application\controllers\ProfileController\UserSettingsController;
use application\controllers\SignupController\SignupController;
use application\controllers\SupportController\SupportController;
use application\controllers\test\test;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;

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
        $push = false;
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
        $push = false;
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

Router::route('/EmailConfirm(/{0,1})', function () {
    require "application/views/templates/emailConfirm.php";
});

Router::route('/confirm(/{0,1})', function () {
    if (isset($_GET['hash'])) {
        VerificationController::emailVerification($_GET['hash']);
    } else {
        echo('Увы что-то пошло не так, попробуйте зарегистрироваться заново!');
    }
});


Router::route('/profileRedactor(/{0,1})', function () {
    $primalEmail = $_POST['primalEmail'];
    $newData = [];

    if (isset($_POST['name'])) {
        $newData['name'] = $_POST['name'];
    }
    if (isset($_POST['date'])) {
        $newData['date'] = $_POST['date'];
    }
    if (isset($_FILES['avatar'])) {
        $newData['avatar'] = $_FILES['avatar'];
    }
    if (isset($_POST['newGroup'])) {
        $newData['newGroup'] = $_POST['newGroup'];
    }
    ProfileRedactor::redactProfile($primalEmail, $newData);
});



Router::route('/logout(/{0,1})', function () {
    LoginController::logout();
});




Router::route('/deleteMe(/{0,1})', function () {
    DB::deleteUser('densisssss@mail.ru');
});



