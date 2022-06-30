<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Group\Group;
use Frisbee\models\User\User;
use Frisbee\views\ProfileView\ProfileView;

class ProfileController
{
    public static function giveProfilePage()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        if (VerificationController::cookieVerification()) {
            $user = new User(['email' => $_COOKIE['email']]);
            $userObtainedData = $user->getData(['userId', 'name', 'date', 'email', 'isNewAvatar']);

            $userId = $userObtainedData[0];
            if ($userObtainedData[4]) {
                $avatar = AvatarsController::getAvatar('user', $userId, true);
                $user = new User(['email' => $_COOKIE['email'], 'isNewAvatar' => 0]);
                $user->updateObject();
            } else {
                $avatar = AvatarsController::getAvatar('user', $userId);
            }

            $userData = ['name' => $userObtainedData[1], 'date' => $userObtainedData[2], 'email' => $userObtainedData[3]];

            $emailGroupTagList = new EmailGroupTaglist(['userId' => (int) $userId]);
            $userGroupsId = $emailGroupTagList->getData(['groupId']);

            $groupsData = [];

            if (count($userGroupsId) == 1) {
                $userGroupsId = [$userGroupsId];
            }

            foreach ($userGroupsId as $item) {
                $groups = new Group(['groupId' => (int) $item[0]]);
                $groupName = $groups->getData(['groupName'])[0];
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
