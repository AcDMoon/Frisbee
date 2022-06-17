<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;
use Frisbee\views\GroupPageView\GroupPageView;

class GroupPageController
{
    private static $userInfo = ['avatar' => '','name' => ''];
    private static $groupInfo = ['groupAvatar' => '','groupName' => '', 'groupId' => ''];
    private static $usersInGroupInfo;


    private static function groupExist($groupId)
    {
        $group = new Groupss(['groupId' => $groupId]);
        $groupInfo = $group->getInfo(['groupId']);
        if ($groupInfo) {
            return;
        }
        require $GLOBALS['base_dir'] . 'views/templates/groupNotExistError.html';
        exit();
    }


    private static function userOnGroupCheck($userId, $groupId)
    {
        $emailGroupTaglist = new EmailGroupTaglist(['groupId' => $groupId]);
        $userInGroup = $emailGroupTaglist->getInfo(['userId']);
        if (count($userInGroup) == 1) {
            if ($userInGroup[0] == $userId) {
                return;
            }
            require $GLOBALS['base_dir'] . 'views/templates/userNotMember.html';
            exit();
        }
        foreach ($userInGroup as $user) {
            if ($userId == $user[0]) {
                return;
            }
        }
        require $GLOBALS['base_dir'] . 'views/templates/userNotMember.html';
        exit();
    }


    private static function userIsOwner($groupId, $userId)
    {
        $owners = new Owners(['groupId' => $groupId]);
        $ownersInfo = $owners->getInfo(['userId']);
        if (count($ownersInfo) == 1) {
            if ($ownersInfo[0] == $userId) {
                return true;
            }
            return false;
        }
        foreach ($ownersInfo as $owner) {
            if ($owner[0] == $userId) {
                return true;
            }
        }
        return false;
    }


    private static function collectUserInfo($userId, $userName)
    {
        self::$userInfo['avatar'] = AvatarsController::getAvatar('user', $userId);
        self::$userInfo['name'] = $userName;
    }


    private static function collectGroupInfo($groupId)
    {
        $group = new Groupss(['groupId' => $groupId]);
        $groupInfo = $group->getInfo(['groupName']);
        self::$groupInfo['groupId'] = $groupId;
        self::$groupInfo['groupName'] = $groupInfo[0];
        self::$groupInfo['groupAvatar'] = AvatarsController::getAvatar('group', $groupId);
    }


    private static function collectUsersGroupInfo($groupId)
    {
        $emailGroupTaglist = new EmailGroupTaglist(['groupId' => $groupId]);
        $usersInGropId = $emailGroupTaglist->getInfo(['userId']);

        $owners = new Owners(['groupId' => $groupId]);
        $ownersInfo = $owners->getInfo(['userId']);

        $usersInGroup = [];

        if (count($usersInGropId) == 1) {
            $user = new User(['userId' => $usersInGropId[0]]);
            $userInfo = $user->getInfo(['name']);
            $userAvatar = AvatarsController::getAvatar('group', $usersInGropId[0]);
            $usersInGroup[] = ['name' => $userInfo[0],'avatar' => $userAvatar, 'isOwner' => true];
        } else {
            foreach ($usersInGropId as $userId) {
                $isOwner = self::userIsOwner($groupId, $userId[0]);
                $user = new User(['userId' => $userId[0]]);
                $userInfo = $user->getInfo(['name']);
                $userAvatar = AvatarsController::getAvatar('user', $userId[0]);
                $usersInGroup[] = ['name' => $userInfo[0],'avatar' => $userAvatar, 'userId' => $userId[0], 'isOwner' => $isOwner];
            }
        }
        self::$usersInGroupInfo = $usersInGroup;
    }


    public static function group($groupId)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $url = 'http://' . $domain['domain'] . '/';
        self::groupExist($groupId);
        if (VerificationController::cookieVerification()) {
            $user = new User(['email' => $_COOKIE['email']]);
            $userInfo = $user->getInfo(['userId', 'name']);
            self::userOnGroupCheck($userInfo[0], $groupId);
            $isModerator = self::userIsOwner($groupId, $userInfo[0]);
            self::collectUserInfo($userInfo[0], $userInfo[1]);
            self::collectGroupInfo($groupId);
            self::collectUsersGroupInfo($groupId);
            GroupPageView::renderGroupPage(self::$userInfo, self::$groupInfo, self::$usersInGroupInfo, $isModerator, $url);
        } else {
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
