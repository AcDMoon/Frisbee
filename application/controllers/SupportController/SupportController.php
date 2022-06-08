<?php

namespace Frisbee\controllers\SupportController;

use Frisbee\controllers\AvatarsController\AvatarsController;
use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;
use Frisbee\views\SupportView\SupportView;

class SupportController
{
    public static function support()
    {
        $avatar = '';
        $name = '';
        if (VerificationController::cookieVerification()) {
            $userId = DB::getUserObject($_COOKIE['email'], ['UserID'])['UserID'];
            $avatar = AvatarsController::getAvatar('user', $userId);
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }
        SupportView::renderSupportPage($avatar, $name);
    }
}
