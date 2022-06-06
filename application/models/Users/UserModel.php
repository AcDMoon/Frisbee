<?php

namespace application\models\Users;

class User
{
    private int $userId;
    private string $email;
    private string $password;
    private string $name;
    private bool $siteRole;
    private string $date;
    private string $hash;
    private bool $verification;

    function __construct($data){
        foreach ($data as $field => $value) {
            $this->${$field} = $value;
        }
    }


    public function getInfo(array $data, array $attributes)
    {
        $user = new User($data);
        $user = newDB::request('get', $user);
        $info = [];
        foreach ($attributes as $attribute) {
            $info[$attribute] = $user->${$attribute};
        }
        return $info;
    }


    public function deleteObject(array $data)
    {
        $user = new User($data);
        $success = newDB::request('delete', $user);
        return $success;
    }


    public function updateObject(array $data)
    {
        $user = new User($data);
        $success = newDB::request('update', $user);
        return $success;
    }


    public function addInfo(array $data)
    {
        $user = new User($data);
        newDB::request('add', $data);
    }
}

