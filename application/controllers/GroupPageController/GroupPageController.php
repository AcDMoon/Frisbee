<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\BirthdayMonitoring\BirthdayMonitoring;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Group\Group;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;
use Frisbee\views\ErrorsView\ErrorsView;
use Frisbee\views\GroupPageView\GroupPageView;

class GroupPageController
{
    private static $userInfo = ['avatar' => '','name' => ''];
    private static $groupInfo = ['groupAvatar' => '','groupName' => '', 'groupId' => '', 'usersId' => [], 'currentUserId' => ''];
    private static $usersInGroupInfo;


    private static function groupExist($groupId)
    {
        $group = new Group(['groupId' => $groupId]);
        $groupInfo = $group->getData(['groupId']);
        if ($groupInfo) {
            return;
        }
        ErrorsView::renderErrorPage('404');
        exit();
    }


    private static function userOnGroupCheck($userId, $groupId)
    {
        $emailGroupTaglist = new EmailGroupTaglist(['groupId' => $groupId]);
        $userInGroup = $emailGroupTaglist->getData(['userId']);
        if (count($userInGroup) == 1) {
            if ($userInGroup[0] == $userId) {
                return;
            }
            ErrorsView::renderErrorPage('403');
            exit();
        }
        foreach ($userInGroup as $user) {
            if ($userId == $user[0]) {
                return;
            }
        }
        ErrorsView::renderErrorPage('403');
        exit();
    }


    private static function userIsOwner($groupId, $userId)
    {
        $owners = new Owners(['groupId' => $groupId]);
        $ownersInfo = $owners->getData(['userId']);
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


    private static function collectGroupInfo($groupId, $currentUserId)
    {
        $group = new Group(['groupId' => $groupId]);
        $groupInfo = $group->getData(['groupName', 'isNewAvatar']);
        self::$groupInfo['groupId'] = $groupId;
        self::$groupInfo['groupName'] = $groupInfo[0];

        if ($groupInfo[1]) {
            self::$groupInfo['groupAvatar'] = AvatarsController::getAvatar('group', $groupId, true);
            $group = new Group(['groupId' => $groupId, 'isNewAvatar' => 0]);
            $group->updateObject();
        } else {
            self::$groupInfo['groupAvatar'] = AvatarsController::getAvatar('group', $groupId);
        }

        self::$groupInfo['currentUserId'] = $currentUserId;
    }


    private static function trackedUserCheck($currentUserId, $userId)
    {
        $birthdayMonitoring = new BirthdayMonitoring(['userId' => $currentUserId]);
        $trackedIdList = $birthdayMonitoring->getData(['monitoringId']);

        if (!$trackedIdList) {
            return 'off';
        }

        if (count($trackedIdList) == 1) {
            if ($trackedIdList[0] == $userId) {
                return 'on';
            } else {
                return 'off';
            }
        }

        foreach ($trackedIdList as $trackedId) {
            if ($trackedId[0] == $userId) {
                return 'on';
            }
        }
        return 'off';
    }


    private static function collectUsersGroupInfo($groupId, $currentUserId)
    {
        $emailGroupTaglist = new EmailGroupTaglist(['groupId' => $groupId]);
        $usersInGropId = $emailGroupTaglist->getData(['userId']);

        $usersInGroup = [];

        if (count($usersInGropId) == 1) {
            self::$groupInfo['usersId'][] = $usersInGropId[0];
            $user = new User(['userId' => $usersInGropId[0]]);
            $userInfo = $user->getData(['name']);
            $userAvatar = AvatarsController::getAvatar('group', $usersInGropId[0]);

            $birthdayMonitoring = new BirthdayMonitoring(['userId' => $usersInGropId[0], 'monitoringId' => $usersInGropId[0]]);
            $trackedIdList = $birthdayMonitoring->getData();

            $userIsTracked = 'off';
            if ($trackedIdList) {
                $userIsTracked = 'on';
            }
            $usersInGroup[] = ['name' => $userInfo[0],'avatar' => $userAvatar, 'isOwner' => true, 'userId' => $usersInGropId[0], 'userIsTracked' => $userIsTracked];
        } else {
            foreach ($usersInGropId as $userId) {
                self::$groupInfo['usersId'][] = $userId[0];

                $isOwner = self::userIsOwner($groupId, $userId[0]);
                $user = new User(['userId' => $userId[0]]);
                $userInfo = $user->getData(['name']);
                $userAvatar = AvatarsController::getAvatar('user', $userId[0]);

                $userIsTracked = self::trackedUserCheck($currentUserId, $userId[0]);

                $usersInGroup[] = ['name' => $userInfo[0],'avatar' => $userAvatar, 'userId' => $userId[0], 'isOwner' => $isOwner, 'userId' => $userId[0], 'userIsTracked' => $userIsTracked];
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
            $userInfo = $user->getData(['userId', 'name']);
            self::userOnGroupCheck($userInfo[0], $groupId);
            $isModerator = self::userIsOwner($groupId, $userInfo[0]);
            self::collectUserInfo($userInfo[0], $userInfo[1]);
            self::collectGroupInfo($groupId, $userInfo[0]);
            self::collectUsersGroupInfo($groupId, $userInfo[0]);
            GroupPageView::renderGroupPage(self::$userInfo, self::$groupInfo, self::$usersInGroupInfo, $isModerator, $url);
        } else {
            header("Location: http://" . $domain['domain'] . "/login");
            exit();
        }
    }
}
