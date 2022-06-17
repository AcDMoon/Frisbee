<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\GroupsInvites\GroupsInvites;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;

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
        return compact('groupId', 'deleteList', 'userId', 'addMember', 'newMemberEmail', 'moderatorsList');
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
            var_dump('проверьте почту!');
            exit();
        }
    }


    private static function addMemberToGroup($hash, $domain)
    {
        $groupInvite = new GroupsInvites(['hash' => $hash]);
        $groupInviteInfo = $groupInvite->getInfo(['userId', 'groupId']);
        if (!$groupInviteInfo) {
            var_dump('error');
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
        if (!$groupId) {
            header("Location: http://" . $domain['domain'] . "/Profile");
        }

        self::deleteMember($deleteList, $groupId, $domain);
        self::addMemberProcedure($newMemberEmail, $groupId, $addMember, $domain);
        self::addModerators($moderatorsList, $groupId, $domain);

        header("Location: http://" . $domain['domain'] . "/group/" . $groupId);
    }
}
