<?php

namespace application\controllers\ProfileController;

use application\controllers\AvatarsController\AvatarsController;
use application\controllers\VerificationController\VerificationController;
use application\core\model\DB;
use application\views\ProfileView\ProfileView;

class ProfileController
{
    public static function profile()
    {
        if (VerificationController::cookieVerification()) {
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $userData = DB::getUserObject($_COOKIE['email'], ['FullName', 'DateOfBirth']);
            $userGroups = DB::getUserGroups($userId);
            $groupsName = [];
            foreach ($userGroups as $item) {
                $groupsName[] = DB::getGroupObject($item, ['groupname'])['groupname'];
            }

            ProfileView::renderProfilePage($avatar, $userData, $groupsName);
        } else {
            $domain = require 'application/config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
