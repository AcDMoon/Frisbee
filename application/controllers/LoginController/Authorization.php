<?php

namespace Frisbee\controllers\LoginController;

use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\models\User\User;

class Authorization
{
    private static $errors = [];


    private static function emptyCheck(string $email, string $password)
    {
        if ('' === $email) {
            self::$errors['email_error'] = 'This field is required';
        }
        if ('' === $password) {
            self::$errors['password_error'] = 'This field is required';
        }
    }



    public static function authorization(string $email, string $password)
    {

        self::emptyCheck($email, $password);

        if (self::$errors) {
            return self::$errors;
        }

        $user = new User(['email' => $email]);
        $userVerification = $user->getInfo(['verification']);

        if (!$userVerification) {
            self::$errors['email_error'] = 'This user does not exist!';
            return self::$errors;
        }

        $match = VerificationController::passwordVerification($email, $password);
        if (!$match) {
            self::$errors['password_error'] = 'Invalid password';
            return self::$errors;
        } else {
            return null;
        }
    }
}
