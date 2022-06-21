<?php

namespace Frisbee\controllers\SignupController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\User\User;

class Registration
{
    private static $errors = [
        'emailErrors' => [],
        'passwordErrors' => [],
        'nameErrors' => [],
        'dateErrors' => []
    ];



    private static function emailCheck(string $email)
    {

        if ($email !== '') {
            $user = new User(['email' => $email]);
            $userInfo = $user->getInfo(['verification']);
            $emailIsset = '';
            if ($userInfo) {
                $emailIsset = $userInfo[0];
            }

            if ($emailIsset) {
                self::$errors['emailErrors'][] = 'This email is already taken!';
            }
            if (preg_match('/\ /', $email) == 1) {
                self::$errors['emailErrors'][] = 'Email must not contain spaces!';
            }
            if (preg_match('/[а-яё]/iu', $email) == 1) {
                self::$errors['emailErrors'][] = 'Email must not contain the Russian alphabet!';
            }
            if (iconv_strlen($email) > 40) {
                self::$errors['emailErrors'][] = 'Email must be less than or equal to 40 characters!';
            }
            if (!self::$errors['emailErrors']) {
                $user->deleteObject();
                return;
            }

        } else {
            self::$errors['emailErrors'][] = 'This field is required!';
        }
    }

    private static function passwordCheck(string $password)
    {
        if ($password == '') {
            self::$errors['passwordErrors'][] = 'This field is required!';
            return;
        }
        if (preg_match('/\ /', $password) == 1) {
            self::$errors['passwordErrors'][] = 'The password must not contain spaces!';
        }
        if (preg_match('/[а-яё]/iu', $password) == 1) {
            self::$errors['passwordErrors'][] = 'The password must not contain the Russian alphabet!';
        }
        if (iconv_strlen($password) < 8) {
            self::$errors['passwordErrors'][] = 'Password must be longer than 8 characters!';
        }
        if (iconv_strlen($password) > 40) {
            self::$errors['passwordErrors'][] = 'Password must be less than or equal to 40 characters!';
        }
    }


    private static function nameCheck(string $name)
    {
        $name = preg_replace('/\s+/', ' ', $name);
        if ($name[0] == ' ') {
            $name = substr_replace($name, '', 0, 1);
        }
        if ($name == '') {
            self::$errors['nameErrors'][] = 'This field is required!';
            return;
        }
        if (iconv_strlen($name) > 40) {
            self::$errors['nameErrors'][] = 'Username must not exceed 40 characters';
        }
        if (!preg_match('/[a-zа-яё]/iu', $name) == 1) {
            self::$errors['nameErrors'][] = 'Username must contain only alphabetic values';
        }
    }


    private static function dateCheck(string $date)
    {
        if (preg_match('/\d{4}(\-\d{2})(\-\d{2})/', $date) == 1) {
            return;
        } else {
            self::$errors['dateErrors'][] = 'This field is required!';
        }
    }


    private static function fieldsIsValid(string $email, string $password, string $name, string $date): bool
    {
        self::emailCheck($email);
        self::passwordCheck($password);
        self::nameCheck($name);
        self::dateCheck($date);

        foreach (self::$errors as $errorsType => $error) {
            if ($error) {
                return false;
            }
        }
        return true;
    }


    private static function hashData($email, $password)
    {
        $emailHash = md5($email . time() . rand(100000, 999999));
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $hash = ['emailHash' => $emailHash, 'passwordHash' => $passwordHash];
        return $hash;
    }


    public static function registrationProcedures(string $email, string $password, string $name, string $date)
    {
        $result = self::fieldsIsValid($email, $password, $name, $date);
        if ($result) {
            $hash = self::hashData($email, $password);
            $user = new User(['email' => $email, 'password' => $password, 'name' => $name, 'date' => $date, 'hash' => $hash['emailHash']]);
            $user->addInfo();
            Cookie::setCookie($email, $hash['passwordHash']);
            $title = 'Frisbee - Email verification';
            $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
            $content = '<p> Someone tried to sign up for an Frisbee account with '. $email .'. If it was you <a href="http://' . $domain['domain'] . '/confirm?hash=' . $hash['emailHash'] . '">, click this, to confirm</a></p>';
            Mailer::sendMessage($email, $title, $content);
            return false;
        } else {
            return self::$errors;
        }
    }
}

//Someone tried to sign up for an Instagram account with kyrisim@mail.ru. If it was you, click this, to confirm.