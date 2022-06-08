<?php

namespace Frisbee\views\NavbarView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class NavbarView
{
    public static function renderNavbar(string $avatar, string $name)
    {
        if ($name) {
            $data = compact('avatar', 'name');
            $navbarUserPart = IncludeOrRequireMethods::requireTemplate('reg-navbar.php', $data);
        } else {
            $data = compact('avatar', 'name');
            $navbarUserPart = IncludeOrRequireMethods::requireTemplate('unreg-navbar.php', $data);
        }
        $data = compact('navbarUserPart');
        $navbar = IncludeOrRequireMethods::requireTemplate('navbar.php', $data);
        return $navbar;
    }
}