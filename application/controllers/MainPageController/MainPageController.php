<?php

namespace Frisbee\controllers\MainPageController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\MainPageView\MainPageView;

class MainPageController
{
    public static function mainPage()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $users = new User(['email' => $_COOKIE['email']]);
            $userInfo = $users->getData(['userId', 'name']);
            $userId = $userInfo[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = $userInfo[1];
        }

        MainPageView::renderMainPage($avatar, $name);
    }
}
