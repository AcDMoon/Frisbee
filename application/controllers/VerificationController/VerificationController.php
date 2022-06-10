<?php

namespace Frisbee\controllers\VerificationController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\models\User\User;

class VerificationController
{
    private static function hashAvailability()
    {
        if (isset($_GET['hash'])) {
            $hash = $_GET['hash'];
            return $hash;
        }
        require $GLOBALS['base_dir'] . 'views/templates/emailConfirmError.html';
        exit();
    }


    public static function emailVerification()
    {
        $hash = self::hashAvailability();

        $user = new User(['hash' => $hash]);
        $userInfo = $user->getInfo(['hash','userId']);
        if ($userInfo) {
            $userId = $userInfo[1];
            $user = new User(['userId' => $userId, 'verification' => '1', 'hash' => '']);
            $user->updateObject();
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            header("Location: http://" . $domain['domain'] . "/login");
        }
        require $GLOBALS['base_dir'] . 'views/templates/verificationError.html';
    }

    public static function passwordVerification(string $email, string $pass): bool
    {
        $user = new User(['email' => $email]);
        $userInfo = $user->getInfo(['password']);
        $userPassword = '';
        if ($userInfo) {
            $userPassword = $userInfo[0];
        }
        if (password_verify($userPassword, $pass) or $pass === $userPassword) {
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
        $user = new User(['email' => $cookieEmail]);
        $userInfo = $user->getInfo(['verification']);
        if (!$userInfo or  0 == $userInfo[0]) {
            return false;
        }

        if (!self::passwordVerification($cookieEmail, $cookiePassword)) {
            return false;
        }
        return true;
    }
}
