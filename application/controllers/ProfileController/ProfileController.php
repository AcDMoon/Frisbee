<?php
namespace application\controllers\ProfileController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class ProfileController
{

    public static function profile()
    {
        if (Cookie::cookieIsset()) {
            $avatar = '../../../public/images/avatar.jpg';
            $data = DB::getUserObject($_COOKIE['email'], ['FullName','DateOfBirth']);
            extract($data);
            $name = $FullName;
            require __DIR__ . '/../../views/profile.php';
        } else {
//            header("Location: http://62.113.98.197/log-in");
            header("Location: http://frisbee/login");
            exit();
        }
    }
}
