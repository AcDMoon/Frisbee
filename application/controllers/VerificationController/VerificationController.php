<?php

namespace application\controllers\VerificationController;

use application\controllers\Cookie\Cookie;
use application\core\model\DB;

class VerificationController
{
    public static function emailVerification($hash)
    {
        $hashIsset = DB::hashIsset($hash);
        if ($hashIsset) {
            DB::setVerificationTrue($hash);
            header("Location: http://frisbee/login");
        }
        echo ('Произошла ошибка! Попробуйте снова перейти по ссылке подтверждения или повторите регистрацию!');
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