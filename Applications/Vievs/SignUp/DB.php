<?php
namespace Applications\Vievs\SignUp;


use PDO;
use PDOException;


class DB
{
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "FRISBEE";

    public static function EmailIsset($Email)
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=FRISBEE", "dbadmin", "12435678");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM User");
            $result1=$stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}