<?php
namespace Frisbee\controllers\LoginController;

use Frisbee\controllers\VerificationController\VerificationController;
use Frisbee\core\model\DB;


class Authorization
{
    private static $errors = [];


    private static function emptyCheck(string $email, string $password)
    {
        if ('' === $email) {
            self::$errors['email_error'] = 'Это поле обязательно для заполнения';
        }
        if ('' === $password) {
            self::$errors['password_error'] = 'Это поле обязательно для заполнения';
        }
    }



    public static function authorization(string $email, string $password)
    {

        self::emptyCheck($email, $password);

        if (self::$errors) {
            return self::$errors;
        }

        $result = DB::emailIsset($email);

        if (!$result) {
            self::$errors['email_error'] = 'Такого пользователя не существует!';
            return self::$errors;
        }

        $match = VerificationController::passwordVerification($email, $password);
        if (!$match) {
            self::$errors['password_error'] = 'Неверный пароль';
            return self::$errors;
        } else {
            return null;
        }
    }
}
