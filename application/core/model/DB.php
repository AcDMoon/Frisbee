<?php

namespace application\core\model;

use PDO;
use PDOException;

class DB
{
    private static $connection;
    private static $data;



    private static function connect()
    {
        $config = require 'application/config/db/db-config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        self::$connection = new PDO($dsn, $config['username'], $config['password']);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    private static function execute($query, $param)
    {
        self::connect();
        try {
            $stmt = self::$connection->prepare($query);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
//            echo "Error: " . $e->getMessage();
        }
    }


    private static function collectUserData($email)
    {
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
        if (!self::$data) {
            return false;
        }
        if (!self::$data['Verification']) {
            return false;
        }
        return true;
    }


    public static function deleteUser($email)
    {
        $query  = "DELETE FROM User WHERE Email = :Email";
        $param = ['Email' => $email];
        self::execute($query, $param);
    }


    public static function hashIsset($hash)
    {
        $query = 'SELECT Hash FROM User WHERE Hash = :Hash';
        $param = ['Hash' => $hash];
        $result = self::execute($query, $param);
        if ($result) {
            return true;
        }
        return false;
    }


    public static function setVerification($hash)
    {
        $query  = "UPDATE User SET Verification = 1 WHERE Hash = :Hash";
        $param = ['Hash' => $hash];
        self::execute($query, $param);
    }


    public static function addUser($email, $password, $name, $date, $hash)
    {
        $query  = "INSERT INTO User (Email, Password, FullName, DateOfBirth, Hash) VALUES (:Email, :Password, :Name, :Date, :Hash)";
        $param = ['Email' => $email, 'Password' => $password, 'Name' => $name, 'Date' => $date, 'Hash' => $hash];
        self::execute($query, $param);
    }


    public static function getUserObject(string $email, array $object = []): array
    {
        self::collectUserData($email);
        $userData['email'] = $email;
        foreach ($object as $value) {
            $userData[$value] = self::$data[$value];
        }
        return $userData;
    }
}
