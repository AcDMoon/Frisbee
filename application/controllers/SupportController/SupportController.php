<?php

namespace Frisbee\controllers\SupportController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\SupportView\SupportView;

class SupportController
{
    public static function support()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $user = new User(['email' => $_COOKIE['email']]);
            $userInfo = $user->getData(['userId','name']);
            $userId = $userInfo[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = $userInfo[1];
        }
        SupportView::renderSupportPage($avatar, $name);
    }
}
