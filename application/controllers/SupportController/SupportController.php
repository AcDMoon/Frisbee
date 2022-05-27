<?php
namespace application\controllers\SupportController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;
use application\views\SupportView\SupportView;

class SupportController
{
    public static function support()
    {
        $avatar='';
        $name='';
        if (Cookie::cookieIsset()) {
            $avatar = '/public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }
        SupportView::renderSupportPage($avatar, $name);
    }
}
