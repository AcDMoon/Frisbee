<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;
use Frisbee\views\ProfileView\ProfileView;

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
            $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
