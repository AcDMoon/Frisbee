<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\User\User;
use Frisbee\views\ProfileView\ProfileView;

class ProfileController
{
    public static function profile()
    {
        if (VerificationController::cookieVerification()) {
            $user = new User(['email' => $_COOKIE['email']]);
            $userInfo = $user->getInfo(['userId', 'name', 'date','email']);

            $userId = $userInfo[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $userData = ['name' => $userInfo[1], 'date' => $userInfo[2], 'email'=>$userInfo[3]];

            $emailGroupTaglist = new EmailGroupTaglist(['userId' => $userId]);
            $userGroupsId = $emailGroupTaglist->getInfo(['groupId']);

            $groupsName = [];
            foreach ($userGroupsId as $item) {
                $groupss = new Groupss(['groupId' => $item]);
                $groupsName[] = $groupss->getInfo(['groupName'])[0];
            }

            ProfileView::renderProfilePage($avatar, $userData, $groupsName);
        } else {
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
