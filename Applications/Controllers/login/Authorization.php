<?php
namespace Applications\Controllers\login;
use Applications\Core\model\DB;

class Authorization
{
    private static $errors = [];

    //Проверяет пустые ли поля
    private static function EmptyCheck(string $email, string $password){
        if ('' === $email){
            self::$errors['email_error'] = 'Это поле обязательно для заполнения';
        }
        if ('' === $password){
            self::$errors['password_error'] = 'Это поле обязательно для заполнения';
        }
    }

    //Проверяет совпадает ли мыло с паролем
    private static function EmailPassMatch(string $email, string $pass){
        $info = DB::GetUserInfo($email, $password=true);
        if ($pass === $info['password']){
            return true;
            }
        return false;
    }

    //Проверяет введённые данные на корректность и возвращает либо массив ошибок или NULL
    public static function authorization(string $email, string $password){
        //проверка на наличие Email и pass
        self::EmptyCheck($email, $password);

        if (self::$errors == true){
            return self::$errors;
        }
        //Проверка на существование Email в БД
        $result = DB::EmailIsset($email);

        if ($result == false){
            self::$errors['email_error'] = 'Такого пользователя не существует!';
            return self::$errors;
        }
        //Проверяет соответсвует ли указанный Email паролю
        $match = self::EmailPassMatch($email, $password);
        if ($match == false){
            self::$errors['password_error'] = 'Неверный пароль';
            return self::$errors;
        }else {
            return NULL;
        }

    }

    //private static function errorCheck(string $email, string $password)
    //Принимает логин и пароль
    //Если они пустые говорит их заполнить
    //Если нет отправляет в БД запрос о существовании логина
    //Если он существует отправляет запрос в бд на получение пароля этого логина
    //сравнивает логин-пароль
    //Если они неверные говорит иди нахуй
    //Если верные записывает куки и посылает на страницу профиля









}

