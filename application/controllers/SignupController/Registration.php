<?php

namespace Frisbee\controllers\SignupController;

use Frisbee\controllers\Cookie\Cookie;
use Frisbee\controllers\Mailer\Mailer;
use Frisbee\models\User\User;

class Registration
{
    private static $errors = [];



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
                $email_Error = 'This email is already taken!';
            } elseif (preg_match('/\ /', $email) == 1) {
                $email_Error = 'Email must not contain spaces!';
            } elseif (preg_match('/[а-яё]/iu', $email) == 1) {
                $email_Error = 'Email must not contain the Russian alphabet!';
            } elseif (iconv_strlen($email) > 40) {
                $email_Error = 'Email must be less than or equal to 40 characters!';
            } else {
                $user->deleteObject();
                return;
            }
        } else {
            $email_Error = 'This field is required!';
        }

        self::$errors['email_Error'] = $email_Error;
    }

    private static function passwordCheck(string $password)
    {
        if ($password == '') {
            $password_Error = 'This field is required!';
        } elseif (preg_match('/\ /', $password) == 1) {
            $password_Error = 'The password must not contain spaces!';
        } elseif (preg_match('/[а-яё]/iu', $password) == 1) {
            $password_Error = 'The password must not contain the Russian alphabet!';
        } elseif (iconv_strlen($password) < 8) {
            $password_Error = 'Password must be longer than 8 characters!';
        } elseif (iconv_strlen($password) > 40) {
            $password_Error = 'Password must be less than or equal to 40 characters!';
        } else {
            return;
        }
        self::$errors['password_Error'] = $password_Error;
    }


    private static function nameCheck(string $name)
    {
        if ($name == '') {
            $name_Error = 'This field is required!';
        } elseif (iconv_strlen($name) > 40) {
            $name_Error = 'Username must not exceed 40 characters';
        } elseif (!preg_match('/[a-zа-яё]/iu', $name) == 1) {
            $name_Error = 'Username must contain only alphabetic values';
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
            $data_Error = 'This field is required!';
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
            $user = new User(['email'=>$email, 'password'=>$password, 'name'=>$name, 'date'=>$date, 'hash'=>$hash['emailHash']]);
            $user->addInfo();
            Cookie::setCookie($email, $hash['passwordHash']);
            $title = 'Frisbee - Email verification';
            $domain = require $GLOBALS['base_dir'] . 'config/validDomain.php';
            $content = '<a href="http://' . $domain['domain'] . '/confirm?hash=' . $hash['emailHash'] . '">To confirm, click this</a>';
            Mailer::sendMessage($email, $title, $content);
            return null;
        } else {
            return $result;
        }
    }
}
