<?php

namespace Frisbee\controllers\AdminRequestController;

use Frisbee\models\Group\Group;
use Frisbee\models\User\User;

class AdminRequestController
{
    private static $data = [];


    private static function convertDataToVariables()
    {
        foreach ($_POST as $item => $value) {
            self::$data[$item] = $value;
        }
    }


    private static function giveData()
    {
        if (!isset(self::$data['giveData'])) {
            return;
        }

        $user = new User(['userId' => -1]);
        $data['users'] = $user->getData();

        $group = new Group(['groupId' => -1]);
        $data['groups'] = $group->getData();

        echo(json_encode($data));
        exit();
    }


    private static function deleteObject()
    {
        if (!isset(self::$data['deleteObject'])) {
            return;
        }
        if (self::$data['entityType'] == 'user') {
            $user = new User(['userId' => self::$data['deleteObject']['id']]);
            $user->deleteObject();
            exit();
        }
        if (self::$data['entityType'] == 'group') {
            $group = new Group(['groupId' => self::$data['deleteObject']['id']]);
            $group->deleteObject();
            exit();
        }
    }


    private static function updateData(): void
    {
        if (!isset(self::$data['updatedData'])) {
            return;
        }
        if (self::$data['entityType'] == 'user') {
            $user = new User(self::$data['updatedData']);
            $user->updateObject();
            echo(json_encode('Ok'));
            exit();
        }
        if (self::$data['entityType'] == 'group') {
            $group = new Group(self::$data['updatedData']);
            $group->updateObject();
            echo(json_encode('Ok'));
            exit();
        }
    }


    public static function processRequest()
    {
        self::convertDataToVariables();
        self::giveData();
        self::updateData();
        self::deleteObject();
        exit();
    }
}
