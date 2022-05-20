<?php
namespace Applications\Controllers\login;
use Applications\Core\model\DB;
use Applications\Controllers\matchOperations\Match;

class Authorization
{
    private static $errors = [];

    //Проверяет пустые ли поля
    private static function emptyCheck(string $email, string $password){
        if ('' === $email){
            self::$errors['email_error'] = 'Это поле обязательно для заполнения';
        }
        if ('' === $password){
            self::$errors['password_error'] = 'Это поле обязательно для заполнения';
        }
    }


    //Проверяет введённые данные на корректность и возвращает либо массив ошибок или NULL
    public static function authorization(string $email, string $password)
    {
        //проверка на наличие Email и pass
        self::emptyCheck($email, $password);

        if (self::$errors == true){
            return self::$errors;
        }
        //Проверка на существование Email в БД
        $result = DB::emailIsset($email);

        if ($result == false){
            self::$errors['email_error'] = 'Такого пользователя не существует!';
            return self::$errors;
        }
        //Проверяет соответсвует ли указанный Email паролю
        $match = Match::emailPasswordMatch($email, $password);
        if (!$match){
            self::$errors['password_error'] = 'Неверный пароль';
            return self::$errors;
        }else {
            return NULL;
        }

    }











}

