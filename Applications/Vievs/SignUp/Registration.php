<?php
namespace Applications\Vievs\SignUp;

class Registration
{

    public static function EmailCheck($Email){
        // проверяем не пустое ли поле
        if($Email !==''){
            //если оно не пустое отсылаем запрос на проверку существования в базе данных
            $EmailIsset = DB::EmailIsset($Email);
            if ($EmailIsset == True) {
                $Email_Error = 'Этот E-mail уже занят';
            }
        }else($Email_Error = 'Это поле является обязательным для заполнения');
        var_dump($Email_Error);
        return $Email_Error;
    }
    public static function PasswordCheck($Password){

    }


}
?>