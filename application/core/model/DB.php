<?php

namespace Frisbee\core\model;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
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


    public static function add($table, $attributes, $values): void
    {
        $param = [];
        $valuesForQuery = $values;
        foreach ($attributes as $index => $value) {
            $param[$value] =  $values[$index];
            $valuesForQuery[$index] = ':' . $value;
        }
        $attributes = implode(', ', $attributes);
        $valuesForQuery = implode(', ', $valuesForQuery);
        $query  = "INSERT INTO $table ( $attributes ) VALUES ( $valuesForQuery )";
        self::execute($query, $param);
    }


    public static function get($table, $attribute, $value)
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


    public static function update($tableName, $attributes, $values, array $keyField): void
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


    public static function delete($table, $attributes, $values): void
    {
        $whereValue = "";
        $param = [];
        foreach ($attributes as $item => $value) {
            $whereValue = $whereValue . $value . " = :" . $value . " AND ";
            $param[$attributes[$item]] = $values[$item];
        }
        $whereValue = substr_replace($whereValue, " ", iconv_strlen($whereValue) - 5);
        $query = "DELETE FROM $table WHERE $whereValue";
        self::execute($query, $param);
    }


    public static function getLastId()
    {
        return self::$lastId;
    }
}
