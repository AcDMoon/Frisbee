<?php

namespace Frisbee\views\NavbarInfoPagesView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarView\NavbarView;

class NavbarInfoPagesView
{
    private static function renderHead($title, $style)
    {
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(string $avatar, string $name, string $h, string $main)
    {
        $navbar = NavbarView::renderNavbar($avatar, $name);
        $data = compact('navbar', 'h', 'main');
        $body = IncludeOrRequireMethods::requireTemplate('navbarInfoPagesBody.php', $data);
        return $body;
    }

    public static function renderNavbarInfoPage(string $avatar, string $name, string $title, string $style, string $h, string $main)
    {
        $head = self::renderHead($title, $style);
        $body = self::renderBody($avatar, $name, $h, $main);
        $data = compact('avatar', 'name', 'body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}