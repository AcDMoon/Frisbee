<?php

namespace Applications\Core\model;


use Applications\Controllers\login\Authorization;
use PDO;
use PDOException;


class DB
{
    private static $conn;
    private static $data;


    //соединение с БД
    private static function connect()
    {
        $config = require __DIR__.'/../../Config/db/db_config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        self::$conn = new PDO($dsn, $config['username'], $config['password']);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //Выполнение запроса
    private static function execute($query, $param)
    {
        self::connect();
        try {
            $stmt = self::$conn->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
//            echo "Error: " . $e->getMessage();
        }
    }

    //Собирает всю информацию о юзере если такая имеется
    private static function collectUserData($email){
        $query = 'SELECT * FROM User WHERE Email = :Email';
        $param = ['Email' => $email];
        $result = self::execute($query, $param);
        if ($result == true) {
            foreach ($result[0] as $item => $value) {
                self::$data[$item] = $value;
            }
        }
    }

    //Проверяет существует ли Email в БД (стоит переработать комманду - тащить из базы все данные о юзере и помещать их в массив, а потом проверять их)
    //Если есть совпадение возвращает проверяемый Email, если нет возвращает пустой массив
    public static function EmailIsset($Email)
    {
        self::collectUserData($Email);
        if (self::$data == false){
            return false;
        }
        return true;
    }

    //Создаёт запись о юзере в БД
    public static function AddUser($Email, $Password, $Name, $Date){
        $query  = "INSERT INTO User (Email, Password, FullName, DateOfBirth) VALUES (:Email, :Password, :Name, :Date)";
        $param = ['Email' => $Email, 'Password'=> $Password, 'Name'=> $Name, 'Date'=> $Date];
        self::execute($query, $param);
    }

    //Отдаёт данные о юзере которые запрашиваются
    public static function GetUserInfo(string $email, bool $password = false, bool $name = false, bool $phone = false, bool $role = false, bool $avatar = false, bool $date = false){
        self::collectUserData($email);
        $userInfo['email'] = $email;

        if ($password) {$userInfo['password'] = self::$data['Password'];}

        if ($name) {$userInfo['name'] = self::$data['FullName'];}

        if ($phone) {$userInfo['phone'] = self::$data['PhoneNumber'];}

        if ($role) {$userInfo['role'] = self::$data['SiteRole'];}

        if ($avatar) {$userInfo['avatar'] = self::$data['Avatar'];}

        if ($date) {$userInfo['date'] = self::$data['DateOfBirth'];}
        return $userInfo;
    }


    //тянет email и пароль и возвращает их
    //public static function EmailPass
    //проверка на совпадение email и пароля
}


