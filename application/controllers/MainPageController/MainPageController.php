<?php

namespace Frisbee\controllers\MainPageController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;
use Frisbee\views\MainPageView\MainPageView;

class MainPageController
{
    public static function mainPage()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        MainPageView::renderMainPage($avatar, $name);
    }
}
