<?php

namespace application\controllers\DonationController;

use application\controllers\AvatarsController\AvatarsController;
use application\controllers\Cookie\Cookie;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;
use application\views\DonationView\DonationView;

class DonationController
{
    public static function donation()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        DonationView::renderDonationPage($avatar, $name);
    }
}
