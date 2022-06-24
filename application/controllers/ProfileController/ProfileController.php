<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\User\User;
use Frisbee\views\ProfileView\ProfileView;

class ProfileController
{
    public static function profile()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        if (VerificationController::cookieVerification()) {
            $user = new User(['email' => $_COOKIE['email']]);
            $userInfo = $user->getData(['userId', 'name', 'date','email']);

            $userId = $userInfo[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $userData = ['name' => $userInfo[1], 'date' => $userInfo[2], 'email' => $userInfo[3]];

            $emailGroupTaglist = new EmailGroupTaglist(['userId' => (int) $userId]);
            $userGroupsId = $emailGroupTaglist->getData(['groupId']);

            $groupsData = [];

            if (count($userGroupsId) == 1) {
                $userGroupsId = [$userGroupsId];
            }

            foreach ($userGroupsId as $item) {
                $groupss = new Groupss(['groupId' => (int) $item[0]]);
                $groupName = $groupss->getData(['groupName'])[0];
                $groupAvatar = AvatarsController::getAvatar('group', $item[0]);
                $groupsData[] = ['groupUrl' => 'http://' . $domain['domain'] . '/group/' . $item[0],
                    'groupName' => $groupName,
                    'groupAvatar' => $groupAvatar];
            }

            ProfileView::renderProfilePage($avatar, $userData, $groupsData);
        } else {
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
