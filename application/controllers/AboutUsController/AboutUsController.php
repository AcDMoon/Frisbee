<?php
namespace application\controllers\AboutUsController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;
use application\views\AboutUsView\AboutUsView;

class AboutUsController
{
    public static function aboutUs()
    {
        $avatar='';
        $name='';
        if (Cookie::cookieIsset()) {
            $avatar = '/public/images/avatar.jpg';
            $name = DB::getUserObject($_COOKIE['email'], ['FullName'])['FullName'];
        }

        AboutUsView::renderAboutUsPage($avatar, $name);
    }
}
