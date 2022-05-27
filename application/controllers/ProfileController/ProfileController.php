<?php
namespace application\controllers\ProfileController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;
use application\views\ProfileView\ProfileView;

class ProfileController
{

    private static array $avatarWarnings = [];

    public static function profile()
    {
        if (Cookie::cookieIsset()) {
            if (isset($_FILES['avatar'])) {
                self::setAvatar($_FILES['avatar']);
            }


            $avatar = '/public/images/avatar.jpg';
            $data = DB::getUserObject($_COOKIE['email'], ['FullName', 'DateOfBirth']);
            extract($data);
            ProfileView::renderProfilePage($avatar, $data);
        } else {
//            header("Location: http://62.113.98.197/log-in");
            header("Location: http://frisbee/login");
            exit();
        }
    }

    private static function setAvatar($avatar)
    {
        self::avatarTypeCheck($avatar['type']);
        self::avatarSizeCheck($avatar['size']);
        //переименовать
        //поместить в папку
        if (empty(self::$avatarWarnings)){
//            $avatar
        }
    }

    private static function avatarTypeCheck(string $type)
    {
        if ('image/jpeg' !== $type and 'image/jpg' !== $type and 'image/png' !== $type) {
            self::$avatarWarnings['type'] = 'Supported image types: png, jpg, jpeg';
        }
    }


    private static function avatarSizeCheck(int $size)
    {
        if ($size > 1000000) {
            self::$avatarWarnings['size'] = 'Image size should not exceed 1 mb';
        }
    }


    private static function createGroup($groupName)
    {
    }

    private static function changeUserData(array $data)
    {
    }
}
