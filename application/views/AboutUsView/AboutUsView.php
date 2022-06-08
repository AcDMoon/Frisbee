<?php

namespace Frisbee\views\AboutUsView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarView\NavbarView;

class AboutUsView
{
    private static function renderHead()
    {
        $style = 'styles/style.css';
        $title = 'About us';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(string $avatar, string $name)
    {
        $navbar = NavbarView::renderNavbar($avatar, $name);
        $data = compact('avatar', 'name', 'navbar');
        $body = IncludeOrRequireMethods::requireTemplate('aboutUsBody.php', $data);
        return $body;
    }

    public static function renderAboutUsPage(string $avatar, string $name)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $name);
        $data = compact('avatar', 'name', 'body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
