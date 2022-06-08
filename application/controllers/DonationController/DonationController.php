<?php

namespace Frisbee\controllers\DonationController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;
use Frisbee\views\DonationView\DonationView;

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
