<?php

namespace application\models\User;

use application\core\model\newDB;

class User
{
    public int $userId;
    public string $email;
    public string $password;
    public string $name;
    public bool $siteRole;
    public string $date;
    public string $hash;
    public bool $verification;

    function __construct($data){
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }


    public function getInfo(array $attributes)
    {
        $user = newDB::request('get', $this);
        $info = [];
        foreach ($attributes as $attribute) {
            $info[$attribute] = $user->$attribute;
        }
        return $info;
    }


    public function deleteObject()
    {
        $success = newDB::request('delete', $this);
        return $success;
    }


    public function updateObject()
    {
        $success = newDB::request('update', $this);
        return $success;
    }


    public function addInfo()
    {
        newDB::request('add', $this);
    }
}

