<?php
namespace application\controllers\MainPageController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class MainPageController
{
    public static function mainPage()
    {

        if (Cookie::cookieIsset()) {
            $avatar = '../../../public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        require __DIR__ . '/../../views/main-page-mobile.php';
    }
}
