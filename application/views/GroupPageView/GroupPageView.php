<?php

namespace Frisbee\views\GroupPageView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
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


    private static function renderModeratorsList($userInGroupInfo, $inputName, $toAdd)
    {




        ob_start();
        foreach ($userInGroupInfo as $user) {
            if ($toAdd) {
                if ($user['isOwner']) {
                    continue;
                }
            } else {
                if (!$user['isOwner']) {
                    continue;
                }
            }
            $name = $user['name'];
            $userId = $user['userId'];
            $data = compact('name', 'userId', 'inputName');
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
            $userId = $user['userId'];
            $userIsTracked = $user['userIsTracked'];
            $isChecked = '';
            if ($userIsTracked == 'on') {
                $isChecked = 'checked';
            }
            $data = compact('name', 'avatar', 'userId', 'userIsTracked', 'isChecked');
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
        return IncludeOrRequireMethods::requireTemplate('head.php', $data);
    }


    private static function renderBody(array $userInfo, array $groupInfo, array $userInGroupInfo, bool $userIsModerator, string $url)
    {
        $navbar = NavbarView::renderNavbar($userInfo['avatar'], $userInfo['name']);

        $deleteList = self::renderDeleteList($userInGroupInfo);

        $addModeratorsList = self::renderModeratorsList($userInGroupInfo, 'moderatorsList[]', true);
        $deleteModeratorsList = self::renderModeratorsList($userInGroupInfo, 'deleteModeratorsList[]', false);

        $moderatorButton = '';
        if ($userIsModerator) {
            $moderatorButton = IncludeOrRequireMethods::requireTemplate('groupPageModerationButton.php');
        }

        $userList = self::renderUserList($userInGroupInfo);

        $groupAvatar = $groupInfo['groupAvatar'];
        $groupId = $groupInfo['groupId'];
        $groupName = $groupInfo['groupName'];
        $usersId = implode(', ', $groupInfo['usersId']);
        $currentUserId = $groupInfo['currentUserId'];



        $data = compact('groupAvatar', 'groupName', 'navbar', 'deleteList', 'addModeratorsList', 'deleteModeratorsList', 'currentUserId', 'moderatorButton', 'userList', 'groupId', 'url', 'usersId');
        return IncludeOrRequireMethods::requireTemplate('groupPageBody.php', $data);
    }


    public static function renderGroupPage(array $userInfo, array $groupInfo, array $userInGroupInfo, bool $userIsModerator, string $url)
    {
        $head = self::renderHead();
        $body = self::renderBody($userInfo, $groupInfo, $userInGroupInfo, $userIsModerator, $url);

        $scriptPath = '/scripts/groupScript.js';
        $data = compact('scriptPath');
        $script = IncludeOrRequireMethods::requireTemplate('script.php', $data);

        $data = compact('body', 'head', 'script');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
