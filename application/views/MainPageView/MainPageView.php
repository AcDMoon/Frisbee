<?php

namespace Frisbee\views\MainPageView;


use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarView\NavbarView;

class MainPageView
{
    private static function renderHead()
    {
        $style = 'styles/style.css';
        $title = 'Main Page';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(string $avatar, string $name)
    {
        $navbar = NavbarView::renderNavbar($avatar, $name);
        $data = compact('avatar', 'name', 'navbar');
        $body = IncludeOrRequireMethods::requireTemplate('mainPageBody.php', $data);
        return $body;
    }

    public static function renderMainPage(string $avatar, string $name)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $name);
        $data = compact('avatar', 'name', 'body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
