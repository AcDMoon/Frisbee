<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\BirthdayMonitoring\BirthdayMonitoring;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\GroupsInvites\GroupsInvites;
use Frisbee\models\Group\Group;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;
use Frisbee\views\ErrorsView\ErrorsView;

class GroupPageModerationController
{
    private static function convertPostToVariables()
    {
        $groupId = $_POST['groupId'] ?? '';
        $newMemberEmail = $_POST['email'] ?? '';
        $userId = $_POST['userId'] ?? '';
        $moderatorsList = $_POST['moderatorsList'] ?? '';
        $deleteModeratorsList = $_POST['deleteModeratorsList'] ?? '';
        $deleteList = $_POST['deleteList'] ?? '';
        $addMember = $_POST['addMember'] ?? '';
        $avatar = $_FILES['groupAvatar'] ?? '';
        $newGroupName = $_POST['newGroupName'] ?? '';
        $deleteGroup = $_POST['deleteGroup'] ?? '';
        $switch = $_POST['switch'] ?? '';
        $currentUserId = $_POST['currentUserId'] ?? '';
        return compact('groupId', 'deleteList', 'userId', 'addMember', 'newMemberEmail', 'moderatorsList', 'deleteModeratorsList', 'avatar', 'newGroupName', 'deleteGroup', 'switch', 'currentUserId');
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
            }
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function addModerators($moderatorsList, $groupId, $domain)
    {
        if ($moderatorsList) {
            foreach ($moderatorsList as $userId) {
                $owners = new Owners(['userId' => $userId, 'groupId' => $groupId]);
                $owners->addData();
            }
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }

    private static function deleteModerators($deleteModeratorsList, $groupId, $domain)
    {
        if ($deleteModeratorsList) {
            foreach ($deleteModeratorsList as $userId) {
                $owners = new Owners(['userId' => $userId, 'groupId' => $groupId]);
                $owners->deleteObject();
            }
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function resetAvatar($avatar, $groupId, $domain)
    {
        if ($avatar) {
            $groups = new Group(['groupId' => $groupId, 'isNewAvatar' => 1]);
            $groups->updateObject();
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
            $group = new Group(['groupId' => $groupId, 'groupName' => $newGroupName]);
            $group->updateObject();
            header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
            exit();
        }
    }


    private static function deleteGroup($deleteGroup, $groupId, $domain)
    {
        if ($deleteGroup) {
            $group = new Group(['groupId' => $groupId]);
            $group->deleteObject();
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }
    }


    private static function addMemberProcedure($newMemberEmail, $groupId, $addMember, $domain)
    {
        if ($addMember) {
            $user = new User(['email' => $newMemberEmail]);
            $userId = $user->getData(['userId'])[0];
            $hash = password_hash($userId . $groupId . time() . rand(100000, 999999), PASSWORD_DEFAULT);

            $groupsInvites = new GroupsInvites(['userId' => $userId, 'groupId' => $groupId]);
            $groupsInvitesData = $groupsInvites->getData([]);
            if ($groupsInvitesData) {
                $groupsInvites->deleteObject();
            }

            $groupsInvites = new GroupsInvites(['userId' => $userId, 'groupId' => $groupId, 'hash' => $hash]);
            $groupsInvites->addData();

            $group = new Group(['groupId' => $groupId]);
            $groupName = $group->getData(['groupName'])[0];

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
        $groupInviteData = $groupInvite->getData(['userId', 'groupId']);
        if (!$groupInviteData) {
            ErrorsView::renderErrorPage('403');
            exit();
        }

        $userGroup = new EmailGroupTaglist(['userId' => $groupInviteData[0], 'groupId' => $groupInviteData[1]]);
        $userGroup->addData();

        $groupInvite->deleteObject();

        header("Location: http://" . $domain['domain'] . "/group/" . $groupInviteData[1]);
        exit();
    }


    public static function editGroup()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');

        if (isset($_GET['hash'])) {
            self::addMemberToGroup($_GET['hash'], $domain);
        }

        $postData = self::convertPostToVariables();
        extract($postData);
        if (!$groupId && !$switch) {
            header("Location: http://" . $domain['domain'] . "/Profile");
            exit();
        }

        self::deleteMember($deleteList, $groupId, $domain);
        self::addMemberProcedure($newMemberEmail, $groupId, $addMember, $domain);
        self::addModerators($moderatorsList, $groupId, $domain);
        self::deleteModerators($deleteModeratorsList, $groupId, $domain);
        self::resetAvatar($avatar, $groupId, $domain);
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
                $birthdayMonitoring->addData();
            }
        }
    }
}
