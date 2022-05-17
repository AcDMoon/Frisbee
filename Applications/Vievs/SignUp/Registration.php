<?php
namespace Applications\Vievs\SignUp;

class Registration
{
    private static $Errors = array();
//    private $Errors = [
//        'Email_Error'=>'',
//        'Password_Error'=>'',
//        'Name_Error'=>'',
//        'Date_Error'=>'',
//    ];

    //Проверяет E-mail на корректность
    private static function EmailCheck($Email){
        // проверяем не пустое ли поле
        if($Email !=='') {
            //если оно не пустое отсылаем запрос на проверку существования в базе данных
            $EmailIsset = DB::EmailIsset($Email);
            //Проверка на пустой массив
            if (empty($EmailIsset) === False) {
                $Email_Error = 'Этот E-mail уже занят!';
            }else {
                return;
            }

        }else{$Email_Error = 'Это поле является обязательным для заполнения!';}

        self::$Errors['Email_Error'] = $Email_Error;
    }

    //Проверяет пароль на корректность
    private static function PasswordCheck($Password){
        if ($Password == ''){
            $Password_Error = 'Это поле является обязательным для заполнения!';
        }elseif(preg_match('/\ /', $Password) == 1){
            $Password_Error = 'Пароль не должен содержать пробелов!';
        }elseif(preg_match('/[а-яё]/iu', $Password) == 1){
            $Password_Error = 'Пароль не должен содержать русского алфавита!';
        }elseif(iconv_strlen($Password)<8){
            $Password_Error = 'Пароль должен быть длиннее 8 символов!';
        }elseif(iconv_strlen($Password)>40){
            $Password_Error = 'Пароль должен быть меньше или равен 40 символова!';
        }else {
            return;
        }
        self::$Errors['Password_Error'] = $Password_Error;
    }

    //Проверяет имя пользователя на корректность
    private static function NameCheck($Name){
        if ($Name == ''){
            $Name_Error = 'Это поле является обязательным для заполнения!';
        }elseif (iconv_strlen($Name) >40){
            $Name_Error = 'Имя пользователя не должно превышать 40 символов';
        }elseif (!preg_match('/[a-zа-яё]/iu', $Name) == 1){
            $Name_Error = 'Имя пользователя должно содержать только буквунные значения';
        }else {
            return;
        }
        self::$Errors['Name_Error'] = $Name_Error;
    }

    //Проверяет дату рождения на корректность
    private static function DateCheck($Date){
        if (preg_match('/\d{4}(\-\d{2})(\-\d{2})/', $Date) ==1 ){
            return;
        }else {$Data_Error = 'Это поле является обязательным для заполнения!';}
        self::$Errors['Date_Error'] = $Data_Error;
    }

    //Отсылает данные на проверку корректности. Если есть ошибки в заполнении возвращает массив с ошибками. Если ошибок нет возвращает NULL.
    private static function Check($Email, $Password, $Name, $Date){
        self::EmailCheck($Email);
        self::PasswordCheck($Password);
        self::NameCheck($Name);
        self::DateCheck($Date);

        foreach (self::$Errors as $error => $errorName)
        {
            if ($errorName !== ''){
                return self::$Errors;}
        }
        return NULL;
    }

    //Отсылает данные введённые пользователем на проверку. Если нет ошибок отправляет запрос в модель для создания записи в БД и возвращает NULL после создания записи. Если есть ошибки возвращает их в контроллер регистрации.
    public static function Reg($Email, $Password, $Name, $Date){
        $result = self::Check($Email, $Password, $Name, $Date);
        if (is_null($result)) {
            DB::AddUser($Email, $Password, $Name, $Date);
            return NULL;
        } else{
            return $result;
        }
    }
}
?>