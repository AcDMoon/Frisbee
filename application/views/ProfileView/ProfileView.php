<?php

namespace Frisbee\views\ProfileView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarView\NavbarView;

class ProfileView
{
    private static function renderHead()
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $style = 'http://' . $domain['domain'] . '/styles/style.css';
        $title = 'Profile';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(string $avatar, array $data, array $groupsInfo)
    {
        extract($data);
        $navbar = NavbarView::renderNavbar($avatar, $name);



        ob_start();
        foreach ($groupsInfo as $group) {
            $groupName = $group['groupName'];
            $groupUrl = $group['groupUrl'];
            $groupAvatar = $group['groupAvatar'];
            $data = compact('groupName', 'groupUrl', 'groupAvatar');
            IncludeOrRequireMethods::requireTemplate('profileGroups.php', $data, false);
        }
        $groups = ob_get_contents();
        ob_end_clean();

        $scriptPath = '/scripts/profileScript.js';
        $data = compact('scriptPath');
        $script = IncludeOrRequireMethods::requireTemplate('script.php', $data);

        $data = compact('avatar', 'name', 'navbar', 'date', 'groups', 'email', 'script');
        $body = IncludeOrRequireMethods::requireTemplate('profileBody.php', $data);
        return $body;
    }

    public static function renderProfilePage(string $avatar, array $data, array $groupsInfo)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $data, $groupsInfo);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
