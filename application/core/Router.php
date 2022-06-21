<?php

namespace Frisbee\core;

use Frisbee\controllers\AboutUsController\AboutUsController;
use Frisbee\controllers\DonationController\DonationController;
use Frisbee\controllers\GroupPageController\GroupInviteController;
use Frisbee\controllers\GroupPageController\GroupPageController;
use Frisbee\controllers\GroupPageController\GroupPageModerationController;
use Frisbee\controllers\LoginController\LoginController;
use Frisbee\controllers\MainPageController\MainPageController;
use Frisbee\controllers\ProfileController\ProfileController;
use Frisbee\controllers\ProfileController\ProfileRedactor;
use Frisbee\controllers\RestorePasswordController\RestorePasswordController;
use Frisbee\controllers\SignupController\SignupController;
use Frisbee\controllers\SupportController\SupportController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\ErrorsView\ErrorsView;
use Frisbee\views\pageWithOnlyOnePrepositionView\pageWithOnlyOnePrepositionView;

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
        ErrorsView::renderErrorPage('404');
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
    SignupController::signup();
});

Router::route('/LogIn(/{0,1})', function () {
    LoginController::login();
});

Router::route('/', function () {
    MainPageController::mainPage();
});

Router::route('/Profile(/{0,1})', function () {
    ProfileController::profile();
});

Router::route('/EmailConfirm(/{0,1})', function () {
    pageWithOnlyOnePrepositionView::renderSimplePage('checkEmail');
});

Router::route('/confirm(/{0,1})', function () {
    VerificationController::emailVerification();
});

Router::route('/restore(/{0,1})', function () {
    RestorePasswordController::passwordResetNavigator();
});

Router::route('/profileRedactor(/{0,1})', function () {
    ProfileRedactor::redactProfile();
});

Router::route('/logout(/{0,1})', function () {
    LoginController::logout();
});

Router::route('/group/(\d+)(/{0,1})', function ($groupId) {
    GroupPageController::group($groupId);
});

Router::route('/editGroup(/{0,1})', function () {
    GroupPageModerationController::editGroup();
});

Router::route('/groupInviteCheck(/{0,1})', function () {
    GroupInviteController::validate();
});


Router::route('/errorss(/{0,1})', function () {
    ErrorsView::renderErrorPage('404');
});


//Only for tests
Router::route('/deleteMe(/{0,1})', function () {
    if (isset($_GET['email'])) {
        $user = new User(['email' => $_GET['email']]);
        $userId = $user->getInfo(['userId'])[0];

        $user = new User(['userId' => $userId]);
        $user->deleteObject();
    }
});

//Only for tests
Router::route('/test(/{0,1})', function () {
    require $GLOBALS['base_dir'] . 'core/model/test.php';
});
