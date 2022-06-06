<?php

namespace application\core\model;

use PDO;
use PDOException;

class newDB
{
    private static $connection;


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


    private static function add()
    {
        $query  = "INSERT INTO $CLASS ($ATTRIBUTES) VALUES ($ATTRIBUTESVALUE)";
        $param = ['UserID' => $userId, 'groupid' => $groupId];
        self::execute($query, $param);

        $query  = "INSERT INTO email_group_taglist (UserID, groupid) VALUES (:UserID, :groupid)";
        $param = ['UserID' => $userId, 'groupid' => $groupId];
        self::execute($query, $param);
    }


    private static function get(){}


    private static function update(){}


    private static function delete(){}


    public static function request(string $method, object $object)
    {

    }


}