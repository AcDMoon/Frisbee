<?php
namespace application\controllers\SupportController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class SupportController
{
    public static function support()
    {

        if (Cookie::cookieIsset()) {
            $avatar = '../../../public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        require __DIR__ . '/../../views/support.php';
    }
}
