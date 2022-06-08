<?php

namespace Frisbee\controllers\VerificationController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\core\model\DB;

class VerificationController
{
    public static function emailVerification($hash)
    {
        $hashIsset = DB::hashIsset($hash);
        if ($hashIsset) {
            DB::setVerificationTrue($hash);
            DB::deleteHash($hash);
            $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
            header("Location: http://" . $domain['domain'] . "/login");
        }
        require $GLOBALS['base_dir'] . 'views/templates/verificationError.html';
    }

    public static function passwordVerification(string $email, string $pass): bool
    {
        $object = ['Password'];
        $data = DB::getUserObject($email, $object);
        if (password_verify($data['Password'], $pass) or $pass === $data['Password']) {
            return true;
        }
        return false;
    }

    public static function cookieVerification(): bool
    {
        if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
            if (self::cookieIsCorrect($_COOKIE['email'], $_COOKIE['password'])) {
                return true;
            } else {
                Cookie::purgeCookie();
                return false;
            }
        } else {
            return false;
        }
    }

    private static function cookieIsCorrect(string $cookieEmail, string $cookiePassword): bool
    {
        if (!DB::emailIsset($cookieEmail)) {
            return false;
        }
        if (!self::passwordVerification($cookieEmail, $cookiePassword)) {
            return false;
        }
        return true;
    }

}