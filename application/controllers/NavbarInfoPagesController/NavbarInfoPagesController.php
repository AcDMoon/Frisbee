<?php

namespace Frisbee\controllers\NavbarInfoPagesController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;
use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\views\NavbarInfoPagesView\NavbarInfoPagesView;

class NavbarInfoPagesController
{
    public static function giveSupportPage()
    {
        $support = IncludeOrRequireMethods::requireConfig('navbarInfoPages.php')['support'];
        self::giveUserData($support);
    }

    public static function giveDonationPage()
    {
        $donation = IncludeOrRequireMethods::requireConfig('navbarInfoPages.php')['donation'];
        self::giveUserData($donation);
    }

    public static function giveAboutUsPage()
    {
        $aboutUs = IncludeOrRequireMethods::requireConfig('navbarInfoPages.php')['aboutUs'];
        self::giveUserData($aboutUs);
    }

    private static function giveUserData($dataArray)
    {
        extract($dataArray);
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $users = new User(['email' => $_COOKIE['email']]);
            $userData = $users->getData(['userId', 'name']);
            $userId = $userData[0];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = $userData[1];
        }
        NavbarInfoPagesView::renderNavbarInfoPage($avatar, $name, $title, $style, $h, $main);
    }
}
