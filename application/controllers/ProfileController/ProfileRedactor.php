<?php

namespace application\controllers\ProfileController;

use application\core\model\DB;

class ProfileRedactor
{
    private static $data = [];

    private static function changeAvatar()
    {
        if (!isset(self::$data['avatar'])) {
            return;
        }
        $id = DB::getUserObject(self::$data['primalEmail'], ['UserID'])['UserID'];
        $imageType = explode('/', self::$data['avatar']['type'])[1];
        $newName = $id . '.' . $imageType;
        copy($_FILES['avatar']['tmp_name'], 'application/lib/profileAvatars/' . $newName);
    }

    private static function changeName()
    {
        if (!isset(self::$data['name'])) {
            return;
        }
        DB::resetUserName(self::$data['primalEmail'], self::$data['name']);
    }

    private static function changeDate()
    {
        if (!isset(self::$data['date'])) {
            return;
        }
        DB::resetUserDate(self::$data['primalEmail'], self::$data['date']);
    }

    private static function createGroup()
    {
        if (!isset(self::$data['newGroup'])) {
            return;
        }
        DB::createGroup(self::$data['primalEmail'], self::$data['newGroup']);
    }

    public static function redactProfile(string $primalEmail, array $newData)
    {
        self::$data['primalEmail'] = $primalEmail;
        foreach ($newData as $item => $value) {
            self::$data[$item] = $value;
        }
        self::changeAvatar();
        self::changeName();
        self::changeDate();
        self::createGroup();
        $domain = require 'application/config/validDomain.php';
        header("Location: http://" . $domain['domain'] . "/profile");
    }
}
