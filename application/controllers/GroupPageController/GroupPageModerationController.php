<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\BirthdayMonitoring\BirthdayMonitoring;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\GroupsInvites\GroupsInvites;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;
use Frisbee\views\ErrorsView\ErrorsView;

class GroupPageModerationController
{
    private static function postDataAvailability()
    {
        $groupId = $_POST['groupId'] ?? '';
        $newMemberEmail = $_POST['newMemberEmail'] ?? '';
        $userId = $_POST['userId'] ?? '';
        $moderatorsList = $_POST['moderatorsList'] ?? '';
        $deleteList = $_POST['deleteList'] ?? '';
        $addMember = $_POST['addMember'] ?? '';
        $avatar = $_FILES['groupAvatar'] ?? '';
        $newGroupName = $_POST['newGroupName'] ?? '';
        $deleteGroup = $_POST['deleteGroup'] ?? '';
        $switch = $_POST['switch'] ?? '';
        $currentUserId = $_POST['currentUserId'] ?? '';
        return compact('groupId', 'deleteList', 'userId', 'addMember', 'newMemberEmail', 'moderatorsList', 'avatar', 'newGroupName', 'deleteGroup', 'switch', 'currentUserId');
    }


    private static function deleteAvatar($id)
    {
        $pattern = '/^' . $id . '\./';
        $avatarsDirectory = 'groupAvatars/';
        foreach (scandir($avatarsDirectory) as $item => $value) {
            if (preg_match($pattern, $value)) {
                unlink($avatarsDirectory . $value);
            }
        }
    }


    private static function deleteMember($deleteList, $groupId, $domain)
    {
        if ($deleteList) {
            foreach ($deleteList as $userId) {
                $userGroup = new EmailGroupTaglist(['userId' => $userId, 'groupId' => $groupId]);
                $userGroup->deleteObject();
                header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
                exit();
            }
        }
    }


    private static function addModerators($moderatorsList, $groupId, $domain)
    {
        if ($moderatorsList) {
            foreach ($moderatorsList as $userId) {
                $owners = new Owners(['userId' => $userId, 'groupId' => $groupId]);
                $owners->addInfo();
                header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
                exit();
            }
        }
    }


    private static function setAvatar($avatar, $groupId, $domain)
    {
        if ($avatar) {
            $imageType = explode('/', $avatar['type'])[1];
            $newName = $groupId . '.' . $imageType;
            self::deleteAvatar($groupId);
            copy($avatar['tmp_name'], 'groupAvatars/' . $newName);
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function setNewGroupName($newGroupName, $groupId, $domain)
    {
        if ($newGroupName) {
            $group = new Groupss(['groupId' => $groupId, 'groupName' => $newGroupName]);
            $group->updateObject();
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function deleteGroup($deleteGroup, $groupId, $domain)
    {
        if ($deleteGroup) {
            $group = new Groupss(['groupId' => $groupId]);
            $group->deleteObject();
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }
    }


    private static function addMemberProcedure($newMemberEmail, $groupId, $addMember, $domain)
    {
        if ($addMember) {
            $user = new User(['email' => $newMemberEmail]);
            $userId = $user->getInfo(['userId'])[0];
            $hash = password_hash($userId . $groupId . time() . rand(100000, 999999), PASSWORD_DEFAULT);

            $groupsInvites = new GroupsInvites(['userId' => $userId, 'groupId' => $groupId]);
            $groupsInvitesInfo = $groupsInvites->getInfo([]);
            if ($groupsInvitesInfo) {
                $groupsInvites->deleteObject();
            }

            $groupsInvites = new GroupsInvites(['userId' => $userId, 'groupId' => $groupId, 'hash' => $hash]);
            $groupsInvites->addInfo();

            $group = new Groupss(['groupId' => $groupId]);
            $groupName = $group->getInfo(['groupName'])[0];

            $title = "Frisbee - You have been invited to the $groupName group";
            $content = '<a href="http://' . $domain['domain'] . '/editGroup?hash=' . $hash . '">To accept the invitation, click on this text</a>';

            Mailer::sendMessage($newMemberEmail, $title, $content);
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function addMemberToGroup($hash, $domain)
    {
        $groupInvite = new GroupsInvites(['hash' => $hash]);
        $groupInviteInfo = $groupInvite->getInfo(['userId', 'groupId']);
        if (!$groupInviteInfo) {
            ErrorsView::renderErrorPage('403');
            exit();
        }

        $userGroup = new EmailGroupTaglist(['userId' => $groupInviteInfo[0], 'groupId' => $groupInviteInfo[1]]);
        $userGroup->addInfo();

        $groupInvite->deleteObject();

        header("Location: http://" . $domain['domain'] . "/group/" . $groupInviteInfo[1]);
        exit();
    }


    public static function editGroup()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');

        if (isset($_GET['hash'])) {
            self::addMemberToGroup($_GET['hash'], $domain);
        }

        $postData = self::postDataAvailability();
        extract($postData);
        if (!$groupId && !$switch) {
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }

        self::deleteMember($deleteList, $groupId, $domain);
        self::addMemberProcedure($newMemberEmail, $groupId, $addMember, $domain);
        self::addModerators($moderatorsList, $groupId, $domain);
        self::setAvatar($avatar, $groupId, $domain);
        self::setNewGroupName($newGroupName, $groupId, $domain);
        self::deleteGroup($deleteGroup, $groupId, $domain);
        self::changeTrackedStatus($currentUserId, $userId, $switch);

        header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
    }



    private static function changeTrackedStatus($currentUserId, $userId, $switch)
    {
        if (!$switch) {
            return;
        }

        $userId = explode(', ', $userId);

        foreach ($userId as $id) {
            $birthdayMonitoring = new BirthdayMonitoring(['userId' => $currentUserId, 'monitoringId' => $id]);
            if ($switch === 'on') {
                $birthdayMonitoring->deleteObject();
            } else {
                $birthdayMonitoring->addInfo();
            }
        }
    }
}
