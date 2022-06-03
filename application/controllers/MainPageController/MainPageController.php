<?php
namespace application\controllers\MainPageController;

use application\controllers\Cookie\Cookie;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;
use application\views\MainPageView\MainPageView;

class MainPageController
{
    public static function mainPage()
    {
        $avatar='';
        $name='';
        if (VerificationController::cookieVerification()) {
            $avatar = '/public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        MainPageView::renderMainPage($avatar, $name);
    }
}
