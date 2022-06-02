<?php

namespace application\controllers\VerificationController;

use application\core\model\DB;

class VerificationController
{
    public static function verification($hash)
    {
        $hashIsset = DB::hashIsset($hash);
        if ($hashIsset) {
            DB::setVerification($hash);
            header("Location: http://frisbee/login");
        }
        echo ('Произошла ошибка! Попробуйте снова перейти по ссылке подтверждения или повторите регистрацию!');
    }




}