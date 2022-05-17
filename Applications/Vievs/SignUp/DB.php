<?php

namespace Applications\Vievs\SignUp;


use PDO;
use PDOException;


class DB
{
    private static $conn;


    //соединение с БД
    private static function connect()
    {
        $config = require 'db_config.php';
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
            echo "Error: " . $e->getMessage();
        }
    }

    //Проверяет существует ли Email в БД
    public static function EmailIsset($Email)
    {
        $query = 'SELECT Email FROM User WHERE Email = :Email';
        $param = ['Email' => $Email];
        $result = self::execute($query, $param);
        return $result;
    }

    //Создаёт запись о юзере в БД
    public static function AddUser($Email, $Password, $Name, $Date){
        $query  = "INSERT INTO User (Email, Password, FullName, DateOfBirth) VALUES (:Email, :Password, :Name, :Date)";
        $param = ['Email' => $Email, 'Password'=> $Password, 'Name'=> $Name, 'Date'=> $Date];
        self::execute($query, $param);
    }
}


//$stmt = $conn->prepare('SELECT EXISTS(SELECT Email FROM User WHERE Email = :Email)');
//$stmt->execute(['Email' => $Email]);
//$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);