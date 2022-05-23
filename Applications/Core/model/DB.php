<?php

namespace Applications\Core\model;


use Applications\Controllers\login\Authorization;
use PDO;
use PDOException;


class DB
{
    private static $conn;
    private static $data;



    private static function connect()
    {
        $config = require __DIR__.'/../../Config/db/db_config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        self::$conn = new PDO($dsn, $config['username'], $config['password']);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    private static function execute($query, $param)
    {
        self::connect();
        try {
            $stmt = self::$conn->prepare($query);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
//            echo "Error: " . $e->getMessage();
        }
    }


    private static function collectUserData($email){
        $query = 'SELECT * FROM User WHERE Email = :Email';
        $param = ['Email' => $email];
        $result = self::execute($query, $param);
        if ($result) {
            foreach ($result[0] as $item => $value) {
                self::$data[$item] = $value;
            }
        }
    }


    public static function emailIsset($Email): bool
    {
        self::collectUserData($Email);
        if (self::$data == false){
            return false;
        }
        return true;
    }


    public static function addUser($Email, $Password, $Name, $Date){
        $query  = "INSERT INTO User (Email, Password, FullName, DateOfBirth) VALUES (:Email, :Password, :Name, :Date)";
        $param = ['Email' => $Email, 'Password'=> $Password, 'Name'=> $Name, 'Date'=> $Date];
        self::execute($query, $param);
    }


    public static function getUserObject(string $email, array $object=[]): array
    {
        self::collectUserData($email);
        $userData['email'] = $email;
        foreach ($object as $value){
            $userData[$value] = self::$data[$value];
        }
        return $userData;
    }



}


