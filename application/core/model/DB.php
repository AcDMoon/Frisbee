<?php

namespace Frisbee\core\model;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use PDO;
use PDOException;

class DB
{
    private static $connection;
    private static $lastId;


    private static function connect()
    {
        $config = IncludeOrRequireMethods::requireConfig('db-config.php');
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        self::$connection = new PDO($dsn, $config['username'], $config['password']);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    private static function execute($query, $param = '')
    {
        self::connect();
        try {
            $stmt = self::$connection->prepare($query);

            if ('' === $param) {
                $stmt->execute();
                self::$lastId = self::$connection->lastInsertId();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $stmt->execute($param);
            self::$lastId = self::$connection->lastInsertId();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
//            echo "Error: " . $e->getMessage();
        }
    }


    private static function add($table, $attributes, $values): void
    {
        $param = [];
        for ($i = 0; $i <= count($attributes) - 1; $i++) {
            $param[$attributes[$i]] = $values[$i];
        }
        for ($i = 0; $i <= count($values) - 1; $i++) {
            $values[$i] = ':' . $attributes[$i];
        }
        $attributes = implode(', ', $attributes);
        $values = implode(', ', $values);
        $query  = "INSERT INTO $table ( $attributes ) VALUES ( $values )";
        self::execute($query, $param);
    }


    private static function get($table, $attribute, $value)
    {
        if ('' === $attribute) {
            $query = "SELECT * FROM $table";
            $receivedData = self::execute($query);
            return $receivedData;
        }
        $whereValue = ':' . $attribute;
        $query = "SELECT * FROM $table WHERE $attribute = $whereValue";
        $param = [$attribute => $value];
        $receivedData = self::execute($query, $param);
        return $receivedData;
    }


    private static function update($tableName, $attributes, $values, array $keyField): void
    {
        $setValue = "";
        for ($i = 0; $i <= count($attributes) - 1; $i++) {
            $setValue = $setValue . $attributes[$i] . " = :" . $attributes[$i] . ", ";
        }
        $setValue = substr_replace($setValue, " ", iconv_strlen($setValue) - 2);
        $whereValue = array_key_first($keyField) . " = :" . array_key_first($keyField);
        $param = [];
        for ($i = 0; $i <= count($attributes) - 1; $i++) {
            $param[$attributes[$i]] = $values[$i];
        }
        $query  = "UPDATE $tableName SET $setValue  WHERE $whereValue";
        self::execute($query, $param);
    }


    private static function delete($table, $attribute, $value): void
    {
        $whereValue = ':' . $attribute;
        $query = "DELETE FROM $table WHERE $attribute = $whereValue";
        $param = [$attribute => $value];
        self::execute($query, $param);
    }


    public static function request(string $method, object $object, string $keyField = '')
    {
        $array = explode('\\', get_class($object));
        $tableName = $array[count($array) - 1];
        $attributes = [];
        $attributesValue = [];
        foreach ($object as $attribute => $value) {
            $attributes[] = $attribute;
            $attributesValue[] = $value;
        }

        if ('add' === $method) {
            self::add($tableName, $attributes, $attributesValue);
            return;
        }

        if ('get' === $method) {
            if (!isset($attribute)) {
                $attribute = '';
                $value = '';
            }
            $receivedData = self::get($tableName, $attribute, $value);
            return $receivedData;
        }

        if ('update' === $method) {
            $keyField = [$keyField => $object->$keyField];
            self::update($tableName, $attributes, $attributesValue, $keyField);
            return;
        }

        if ('delete' === $method) {
            self::delete($tableName, $attribute, $value);
            return;
        }
    }


    public static function getLastId()
    {
        return self::$lastId;
    }
}
