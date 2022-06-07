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


    private static function add($table, $attributes, $values)
    {
        $param = [];
        for($i = 0; $i <= count($attributes) - 1; $i++ ) {
            $param[$attributes[$i]] = $values[$i];
        }
        for($i = 0; $i <= count($values) - 1; $i++ ) {
            $values[$i] = ':' . $attributes[$i];
        }
        $attributes = implode(', ', $attributes);
        $values = implode(', ', $values );
        $query  = "INSERT INTO $table ( $attributes ) VALUES ( $values )";
        self::execute($query, $param);
    }


    private static function get()
    {
    }


    private static function update()
    {
    }


    private static function delete()
    {
    }


    public static function request(string $method, object $object)
    {
        if ('add' === $method) {
            $array = explode('\\', get_class($object));
            $tableName = $array[count($array) - 1];
            $attributes = [];
            $attributesValue = [];

            foreach ($object as $attribute => $value) {
                $attributes[] = $attribute;
                $attributesValue[] = $value;
            }
            self::add($tableName, $attributes, $attributesValue);
        }

        if ('get' === $method) {
            self::get();
        }

        if ('update' === $method) {
            self::update();
        }

        if ('delete' === $method) {
            self::delete();
        }
    }
}
