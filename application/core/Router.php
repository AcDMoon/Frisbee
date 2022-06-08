<?php

namespace Frisbee\core;

use Frisbee\controllers\AboutUsController\AboutUsController;
use Frisbee\controllers\DonationController\DonationController;
use Frisbee\controllers\LoginController\LoginController;
use Frisbee\controllers\MainPageController\MainPageController;
use Frisbee\controllers\ProfileController\ProfileController;
use Frisbee\controllers\ProfileController\ProfileRedactor;
use Frisbee\controllers\ProfileController\UserSettingsController;
use Frisbee\controllers\RestorePasswordController\RestorePasswordController;
use Frisbee\controllers\SignupController\SignupController;
use Frisbee\controllers\SupportController\SupportController;
use Frisbee\controllers\test\test;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;

class Router
{
    private static $routes = array();

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

    $email = $_POST['email'] ?? '';

    $password = $_POST['password'] ?? '';

    $name = $_POST['name'] ?? '';

    $date = $_POST['date'] ?? '';

    $push = $_POST['push'] ?? false;

    SignupController::signup($email, $password, $name, $date, $push);
});

Router::route('/LogIn(/{0,1})', function () {


    $destination = $_GET['destination'] ?? '';

    $email = $_POST['email'] ?? '';

    $password = $_POST['password'] ?? '';


    $push = $_POST['push'] ?? false;

    LoginController::login($email, $password, $destination, $push);
});

Router::route('/', function () {
    MainPageController::mainPage();
});

Router::route('/Profile(/{0,1})', function () {
    ProfileController::profile();
});

Router::route('/Group(/{0,1})', function () {
    require $GLOBALS['base_dir'] . 'views/group-page/group-page.php';
});

Router::route('/EmailConfirm(/{0,1})', function () {
    require $GLOBALS['base_dir'] . 'views/templates/emailConfirm.php';
});

Router::route('/confirm(/{0,1})', function () {
    if (isset($_GET['hash'])) {
        VerificationController::emailVerification($_GET['hash']);
    } else {
        require $GLOBALS['base_dir'] . 'views/templates/emailConfirmError.html';
    }
});

Router::route('/restore(/{0,1})', function () {
    $hash = $_GET['hash'] ?? '';
    $email = $_POST['email'] ?? '';
    $emailFromHash = $_POST['emailFromHash'] ?? '';
    $password = $_POST['password'] ?? '';
    $buttonIsPush = $_POST['push'] ?? false;
    RestorePasswordController::passwordResetNavigator($email, $emailFromHash, $password, $hash, $buttonIsPush);
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
    if (isset($_GET['email'])) {
        $userId = DB::getUserObject($_GET['email'], ['UserID'])['UserID'];
        DB::deleteUser($userId);
    }

});


Router::route('/test(/{0,1})', function () {
    require $GLOBALS['base_dir'] . 'core/model/test.php';
});
