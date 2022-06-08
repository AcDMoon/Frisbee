<?php

namespace Frisbee\controllers\DonationController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\DonationView\DonationView;

class DonationController
{
    public static function donation()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $users = new User(['email' => $_COOKIE['email']]);
            $userInfo = $users->getInfo(['userId', 'name']);
            $userId = $userInfo[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = $userInfo[1];
        }

        DonationView::renderDonationPage($avatar, $name);
    }
}
