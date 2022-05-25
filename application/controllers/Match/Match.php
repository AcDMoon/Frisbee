<?php
namespace application\controllers\Match;

use application\core\model\DB;

class Match
{
    public static function emailPasswordMatch(string $email, string $pass): bool
    {
        $object = ['Password'];
        $data = DB::getUserObject($email, $object);
        if ($pass === $data['Password']) {
            return true;
        }
        return false;
    }


    public static function cookiesMatchData(string $cookieEmail, string $cookiePassword): bool
    {
        if (!DB::emailIsset($cookieEmail)) {
            return false;
        }
        if (!Match::emailPasswordMatch($cookieEmail, $cookiePassword)) {
            return false;
        }
        return true;
    }
}
