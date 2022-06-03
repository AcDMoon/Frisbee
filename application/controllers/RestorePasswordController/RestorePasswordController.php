<?php

namespace application\controllers\RestorePasswordController;

use application\controllers\Mailer\Mailer;
use application\core\model\DB;

class RestorePasswordController
{
    public static function restorePasswordProcedure($email)
    {
        if (DB::emailIsset($email)) {
            $hash = md5($email . time() . rand(100000, 999999));
            DB::setHash($email, $hash);
            $title = 'Frisbee - Restore password';
            $domain = require 'application/config/validDomain.php';
            $content = '<a href="http://' . $domain['domain'] . '/restorePassword?hash=' . $hash . '">To restore, click this</a>';
            Mailer::sendMessage($email, $title, $content);
            //говорим перейти на почту для подтверждения
        } else {
        //выдаём то же окно с ошибкой
        }
    }

}

//переход на страницу восстановления пароля
//если хэш отсутствует или ненаходится генерируем ошибку
//если есть выдаём форму
//форма проверяет корректность (можно скриптом)
//если форма отправляется записываем новый пароль в бд
//создаём куки с новым паролем
//пересылаем на страницу логина



//сделать странички ошибок