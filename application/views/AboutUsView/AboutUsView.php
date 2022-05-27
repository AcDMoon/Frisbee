<?php

namespace application\views\AboutUsView;

use application\views\NavbarView\NavbarView;

class AboutUsView
{
    private static function renderHead()
    {
        $style = 'public/styles/style.css';
        $title = 'About us';
        ob_start();
        require 'application/views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }

    private static function renderBody(string $avatar, string $name)
    {
        $navbar = NavbarView::renderNavbar($avatar, $name);

        ob_start();
        require 'application/views/templates/aboutUsBody.php';
        $body = ob_get_contents();
        ob_end_clean();

        return $body;
    }

    public static function renderAboutUsPage(string $avatar, string $name)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $name);
        require 'application/views/templates/html.php';
    }
}
