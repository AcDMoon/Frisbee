<?php
namespace application\controllers\DonationController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class DonationController
{
    public static function donation()
    {

        if (Cookie::cookieIsset()) {
            $avatar = '../../../public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        require __DIR__ . '/../../views/donation.php';
    }
}
