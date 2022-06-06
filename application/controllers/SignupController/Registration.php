<?php

namespace application\controllers\SignupController;

use application\controllers\Cookie\Cookie;
use application\controllers\Mailer\Mailer;
use application\core\model\DB;

class Registration
{
    private static $errors = [];



    private static function emailCheck(string $email)
    {

        if ($email !== '') {
            $emailIsset = DB::emailIsset($email);

            if ($emailIsset) {
                $email_Error = 'Этот E-mail уже занят!';
            } elseif (preg_match('/\ /', $email) == 1) {
                $email_Error = 'Email не должен содержать пробелов!';
            } elseif (preg_match('/[а-яё]/iu', $email) == 1) {
                $email_Error = 'Email не должен содержать русского алфавита!';
            } elseif (iconv_strlen($email) > 40) {
                $email_Error = 'Email должен быть меньше или равен 40 символова!';
            } else {
                $userId = DB::getUserObject($email, ['UserID'])['UserID'];
                DB::deleteUser($userId);
                return;
            }
        } else {
            $email_Error = 'Это поле является обязательным для заполнения!';
        }

        self::$errors['email_Error'] = $email_Error;
    }


    private static function passwordCheck(string $password)
    {
        if ($password == '') {
            $password_Error = 'Это поле является обязательным для заполнения!';
        } elseif (preg_match('/\ /', $password) == 1) {
            $password_Error = 'Пароль не должен содержать пробелов!';
        } elseif (preg_match('/[а-яё]/iu', $password) == 1) {
            $password_Error = 'Пароль не должен содержать русского алфавита!';
        } elseif (iconv_strlen($password) < 8) {
            $password_Error = 'Пароль должен быть длиннее 8 символов!';
        } elseif (iconv_strlen($password) > 40) {
            $password_Error = 'Пароль должен быть меньше или равен 40 символова!';
        } else {
            return;
        }
        self::$errors['password_Error'] = $password_Error;
    }


    private static function nameCheck(string $name)
    {
        if ($name == '') {
            $name_Error = 'Это поле является обязательным для заполнения!';
        } elseif (iconv_strlen($name) > 40) {
            $name_Error = 'Имя пользователя не должно превышать 40 символов';
        } elseif (!preg_match('/[a-zа-яё]/iu', $name) == 1) {
            $name_Error = 'Имя пользователя должно содержать только буквунные значения';
        } else {
            return;
        }
        self::$errors['name_Error'] = $name_Error;
    }


    private static function dateCheck(string $date)
    {
        if (preg_match('/\d{4}(\-\d{2})(\-\d{2})/', $date) == 1) {
            return;
        } else {
            $data_Error = 'Это поле является обязательным для заполнения!';
        }
        self::$errors['date_Error'] = $data_Error;
    }


    private static function fieldsCheck(string $email, string $password, string $name, string $date)
    {
        self::emailCheck($email);
        self::passwordCheck($password);
        self::nameCheck($name);
        self::dateCheck($date);

        foreach (self::$errors as $error => $errorName) {
            if ($errorName !== '') {
                return self::$errors;
            }
        }
        return null;
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
        $result = self::fieldsCheck($email, $password, $name, $date);
        if (is_null($result)) {
            $hash = self::hashData($email, $password);
            DB::addUser($email, $password, $name, $date, $hash['emailHash']);
            Cookie::setCookie($email, $hash['passwordHash']);
            $title = 'Frisbee - Email verification';
            $domain = require 'application/config/validDomain.php';
            $content = '<a href="http://' . $domain['domain'] . '/confirm?hash=' . $hash['emailHash'] . '">To confirm, click this</a>';
            Mailer::sendMessage($email, $title, $content);
            return null;
        } else {
            return $result;
        }
    }
}

