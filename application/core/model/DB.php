<?php

namespace application\core\model;

use PDO;
use PDOException;

class DB
{
    private static $connection;
    private static $userData;
    private static $groupData;



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
                self::$userData[$item] = $value;
            }
        }
    }


    public static function emailIsset($Email): bool
    {
        self::collectUserData($Email);
        if (!self::$userData) {
            return false;
        }
        if (!self::$userData['Verification']) {
            return false;
        }
        return true;
    }


    public static function deleteUser($userId)
    {
        $query  = "DELETE FROM User WHERE UserID = :UserID";
        $param = ['UserID' => $userId];
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


    public static function setHash($email, $hash)
    {
        $query  = "UPDATE User SET Hash = :Hash WHERE Email = :Email";
        $param = ['Hash' => $hash, 'Email'=> $email];
        self::execute($query, $param);
    }


    public static function deleteHash($hash)
    {
        $query  = "UPDATE User SET Hash = '' WHERE Hash = :Hash";
        $param = ['Hash' => $hash];
        self::execute($query, $param);
    }


    public static function getEmailFromHash($hash)
    {
        $query = 'SELECT Email FROM User WHERE Hash = :Hash';
        $param = ['Hash' => $hash];
        $email = self::execute($query, $param);
        return $email;
    }


    public static function setVerificationTrue($hash)
    {
        $query  = "UPDATE User SET Verification = 1 WHERE Hash = :Hash";
        $param = ['Hash' => $hash];
        self::execute($query, $param);
    }


    public static function resetUserName($email, $name)
    {
        $query  = "UPDATE User SET FullName = :Name WHERE Email = :Email";
        $param = ['Email' => $email, 'Name' => $name];
        self::execute($query, $param);
    }


    public static function resetUserDate($email, $date)
    {
        $query  = "UPDATE User SET DateOfBirth = :Date WHERE Email = :Email";
        $param = ['Email' => $email, 'Date' => $date];
        self::execute($query, $param);
    }

    public static function resetUserPassword($email, $password)
    {
        $query  = "UPDATE User SET Password = :Password WHERE Email = :Email";
        $param = ['Email' => $email, 'Password' => $password];
        self::execute($query, $param);
    }


    public static function createGroup($owner, $groupName)
    {
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d', time());
        $query  = "INSERT INTO Groupss (groupname, owners, data_of_create, uservalue) VALUES (:groupname, :owners, :data_of_create, :uservalue)";
        $param = ['groupname' => $groupName, 'owners' => $owner, 'data_of_create' => $date, 'uservalue' => 1];
        self::execute($query, $param);
        $groupId = self::$connection->lastInsertId();
        $userId = self::getUserObject($owner, ['UserID'])['UserID'];
        self::addGroupUser($userId, $groupId);
    }


    public static function addGroupUser($userId, $groupId)
    {
        $query  = "INSERT INTO email_group_taglist (UserID, groupid) VALUES (:UserID, :groupid)";
        $param = ['UserID' => $userId, 'groupid' => $groupId];
        self::execute($query, $param);
    }


    private static function collectGroupData($groupId)
    {
        $query = 'SELECT * FROM Groupss WHERE groupid = :groupid';
        $param = ['groupid' => $groupId];
        $result = self::execute($query, $param);
        if ($result) {
            foreach ($result[0] as $item => $value) {
                self::$groupData[$item] = $value;
            }
        }
    }


    public static function getGroupObject(string $groupId, array $object = [])
    {
        self::collectGroupData($groupId);
        $groupData['groupId'] = $groupId;
        foreach ($object as $value) {
            $groupData[$value] = self::$groupData[$value];
        }
        return $groupData;
    }


    public static function getUserGroups($userId)
    {
        $query = 'SELECT groupid FROM email_group_taglist WHERE UserID = :UserID';
        $param = ['UserID' => $userId];
        $userGroupsIdArray = self::execute($query, $param);
        $userGroupsId = [];
        foreach ($userGroupsIdArray as $item) {
            $userGroupsId[] = $item['groupid'];
        }
        return $userGroupsId;
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
            $userData[$value] = self::$userData[$value];
        }
        return $userData;
    }
}
