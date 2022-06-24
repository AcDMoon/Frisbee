<?php

namespace Frisbee\controllers\AboutUsController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\AboutUsView\AboutUsView;

class AboutUsController
{
    public static function aboutUs()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $users = new User(['email' => $_COOKIE['email']]);
            $userData = $users->getData(['userId', 'name']);
            $userId = $userData[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = $userData[1];
        }
        AboutUsView::renderAboutUsPage($avatar, $name);
    }
}
