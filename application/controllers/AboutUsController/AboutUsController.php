<?php
namespace application\controllers\AboutUsController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class AboutUsController
{
    public static function aboutUs()
    {

        if (Cookie::cookieIsset()) {
            $avatar = '../../../public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        require __DIR__ . '/../../views/about-us.php';
    }
}
