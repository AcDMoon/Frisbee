<?php

namespace Frisbee\views\ProfileView;

use Frisbee\views\NavbarView\NavbarView;

class ProfileView
{
    private static function renderHead()
    {
        $style = 'styles/style.css';
        $title = 'Profile';
        ob_start();
        require $GLOBALS['base_dir'] . 'views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }

    private static function renderBody(string $avatar, array $data, array $groupsName)
    {
        extract($data);
        $navbar = NavbarView::renderNavbar($avatar, $FullName);

        ob_start();
        foreach ($groupsName as $item) {
            require $GLOBALS['base_dir'] . 'views/templates/profileGroups.php';
        }
        $groups = ob_get_contents();
        ob_end_clean();


        ob_start();
        require $GLOBALS['base_dir'] . 'views/templates/profileBody.php';
        $body = ob_get_contents();
        ob_end_clean();

        return $body;
    }

    public static function renderProfilePage(string $avatar, array $data, array $groupsName)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $data, $groupsName);
        require $GLOBALS['base_dir'] . 'views/templates/html.php';
    }
}
