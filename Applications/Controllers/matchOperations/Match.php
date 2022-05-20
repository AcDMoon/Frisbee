<?php
namespace Applications\Controllers\matchOperations;

use Applications\Core\model\DB;

class Match
{
    public static function emailPasswordMatch(string $email, string $pass): bool
    {
        $object = ['Password'];
        $data = DB::getUserObject($email, $object);
        if ($pass === $data['Password']){
            return true;
        }
        return false;
    }


    public static function cookiesMatchData(string $cookieEmail, string $cookiePassword): bool
    {
        if (!DB::emailIsset($cookieEmail)) {
            return false;
        }
        if (!Match::emailPasswordMatch($cookieEmail, $cookiePassword)) {
            return false;
        }
        return true;
    }

    //забирает куки
    //запрашвает по мылу куки пароль
    //если мыла нет возвращает false
    //если пароля нет возвращает false
    //если всё совпало перенеправляет на страницу профиля или группы или профиля группы

    //основная страница -> навбар с профилем else навбар без профиля
    //логин -> перекидывает на профиль else перекидывает на логинку
    //регистрация -> перекидывает на профиль else перекидывает на логинку
    //профиль -> перекидывает на профиль else перекидывает на логинку
    //группа -> перекидывает на группу  else перекидывает на логинку
    //
}