<?php

namespace application\views\DonationView;

use application\views\NavbarView\NavbarView;

class DonationView
{
    private static function renderHead()
    {
        $style = 'public/styles/style.css';
        $title = 'Donation';
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
        require 'application/views/templates/donationBody.php';
        $body = ob_get_contents();
        ob_end_clean();

        return $body;
    }

    public static function renderDonationPage(string $avatar, string $name)
    {
        $head = self::renderHead();
        $body = self::renderBody($avatar, $name);
        require 'application/views/templates/html.php';
    }
}
