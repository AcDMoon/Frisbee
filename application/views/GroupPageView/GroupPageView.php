<?php

namespace Frisbee\views\GroupPageView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarView\NavbarView;

class GroupPageView
{
    private static function renderDeleteList($userInGroupInfo)
    {
        ob_start();
        foreach ($userInGroupInfo as $user) {
            if ($user['isOwner']) {
                continue;
            }
            $inputName = 'deleteList[]';
            $isOwner = $user['isOwner'];
            $name = $user['name'];
            $userId = $user['userId'];
            $data = compact('name', 'userId', 'isOwner', 'inputName');
            IncludeOrRequireMethods::requireTemplate('groupPageMembersList.php', $data, false);
        }
        $deleteList = ob_get_contents();
        ob_end_clean();
        return $deleteList;
    }


    private static function renderModeratorsList($userInGroupInfo)
    {
        ob_start();
        foreach ($userInGroupInfo as $user) {
            if ($user['isOwner']) {
                continue;
            }
            $inputName = 'moderatorsList[]';
            $isOwner = $user['isOwner'];
            $name = $user['name'];
            $userId = $user['userId'];
            $data = compact('name', 'userId', 'isOwner', 'inputName');
            IncludeOrRequireMethods::requireTemplate('groupPageMembersList.php', $data, false);
        }
        $moderatorsList = ob_get_contents();
        ob_end_clean();
        return $moderatorsList;
    }


    private static function renderUserList($userInGroupInfo)
    {
        ob_start();
        foreach ($userInGroupInfo as $user) {
            $name = $user['name'];
            $avatar = $user['avatar'];
            $data = compact('name', 'avatar');
            IncludeOrRequireMethods::requireTemplate('groupPageMembers.php', $data, false);
        }
        $userList = ob_get_contents();
        ob_end_clean();
        return $userList;
    }


    private static function renderHead()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $style = 'http://' . $domain['domain'] . '/styles/group-page-style.css';
        $title = 'Group';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }


    private static function renderBody(array $userInfo, array $groupInfo, array $userInGroupInfo, bool $userIsModerator, string $url)
    {
        $navbar = NavbarView::renderNavbar($userInfo['avatar'], $userInfo['name']);

        $deleteList = self::renderDeleteList($userInGroupInfo);

        $addModeratorsList = self::renderModeratorsList($userInGroupInfo);

        $moderatorButton = '';
        if ($userIsModerator) {
            $moderatorButton = IncludeOrRequireMethods::requireTemplate('groupPageModerationButton.php');
        }

        $userList = self::renderUserList($userInGroupInfo);

        $groupAvatar = $groupInfo['groupAvatar'];
        $groupId = $groupInfo['groupId'];
        $groupName = $groupInfo['groupName'];

        $scriptPath = '/scripts/groupScript.js';
        $data = compact('scriptPath');
        $script = IncludeOrRequireMethods::requireTemplate('script.php', $data);

        $data = compact('groupAvatar', 'groupName', 'navbar', 'deleteList', 'addModeratorsList', 'moderatorButton', 'userList', 'groupId', 'url', 'script');
        $body = IncludeOrRequireMethods::requireTemplate('groupPageBody.php', $data);
        return $body;
    }




    public static function renderGroupPage(array $userInfo, array $groupInfo, array $userInGroupInfo, bool $userIsModerator, string $url)
    {
        $head = self::renderHead();
        $body = self::renderBody($userInfo, $groupInfo, $userInGroupInfo, $userIsModerator, $url);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
