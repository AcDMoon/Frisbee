<?php

namespace application\views\NavbarView;

class NavbarView
{
    public static function renderNavbar(string $avatar, string $name)
    {
        if ($name) {
            ob_start();
            require 'application/views/templates/reg-navbar.php';
            $navbarUserPart = ob_get_contents();
            ob_end_clean();
        } else {
            ob_start();
            require 'application/views/templates/unreg-navbar.php';
            $navbarUserPart = ob_get_contents();
            ob_end_clean();
        }
        ob_start();
        require 'application/views/templates/navbar.php';
        $navbar = ob_get_contents();
        ob_end_clean();

        return $navbar;
    }
}