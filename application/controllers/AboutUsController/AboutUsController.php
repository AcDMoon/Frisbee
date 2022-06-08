<?php

namespace Frisbee\controllers\AboutUsController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;
use Frisbee\views\AboutUsView\AboutUsView;

class AboutUsController
{
    public static function aboutUs()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        AboutUsView::renderAboutUsPage($avatar, $name);
    }
}
