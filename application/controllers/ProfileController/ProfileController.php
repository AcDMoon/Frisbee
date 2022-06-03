<?php

namespace application\controllers\ProfileController;

use application\controllers\Cookie\Cookie;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;
use application\views\ProfileView\ProfileView;

class ProfileController
{
    public static function profile()
    {
        if (VerificationController::cookieVerification()) {
            $avatar = '/public/images/avatar.jpg';
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $pattern = '/^' . $userId . '\./';
            $avatarsDirectory = 'application/lib/profileAvatars/';
            foreach (scandir($avatarsDirectory) as $item => $value) {
                if (preg_match($pattern, $value)) {
                    $avatar = $avatarsDirectory . $value;
                }
            }

            $userData = DB::getUserObject($_COOKIE['email'], ['FullName', 'DateOfBirth']);
            $userGroups = DB::getUserGroups($userId);
            $groupsName = [];
            foreach ($userGroups as $item) {
                $groupsName[] = DB::getGroupObject($item, ['groupname'])['groupname'];
            }

            ProfileView::renderProfilePage($avatar, $userData, $groupsName);
        } else {
//            header("Location: http://62.113.98.197/log-in");
            header("Location: http://frisbee/login");
            exit();
        }
    }
}
