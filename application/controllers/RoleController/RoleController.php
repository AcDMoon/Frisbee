<?php

namespace Frisbee\controllers\RoleController;

use Frisbee\models\User\User;

class RoleController
{
    //0 -> default state, 1 -> user banned, 2 -> user is admin
    private static function giveUserRole($email)
    {
        $user = new User(['email' => $email]);
        return $user->getData(['siteRole'])[0];
    }


    public static function userBanned($email)
    {
        $roleNumber = self::giveUserRole($email);
        if ($roleNumber == 1) {
            return true;
        }
        return false;
    }


    public static function userIsAdmin($email)
    {
        $roleNumber = self::giveUserRole($email);
        if ($roleNumber == 2) {
            return true;
        }
        return false;
    }
}
