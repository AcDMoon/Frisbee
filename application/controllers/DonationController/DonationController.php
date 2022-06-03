<?php
namespace application\controllers\DonationController;

use application\controllers\Cookie\Cookie;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;
use application\views\DonationView\DonationView;

class DonationController
{
    public static function donation()
    {
        $avatar='';
        $name='';
        if (VerificationController::cookieVerification()) {
            $avatar = '/public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        DonationView::renderDonationPage($avatar, $name);
    }
}
