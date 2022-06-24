<?php

namespace Frisbee\controllers\GroupPageController;

use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\User\User;

class GroupInviteController
{
    private static function convertPostToVariables(): array
    {
        $email = $_POST['email'] ?? '';
        $groupId = $_POST['groupId'] ?? '';
        return compact('groupId', 'email');
    }


    private static function emailIsExistCheck($email): bool
    {
        $user = new User(['email' => $email]);
        $userData = $user->getData(['email']);
        if (!$userData) {
            return false;
        }
        return true;
    }


    private static function userAlreadyInGroupCheck($email, $groupId)
    {
        $user = new User(['email' => $email]);
        $userId = $user->getData(['userId'])[0];


        $usersGroups = new EmailGroupTaglist(['groupId' => $groupId, 'userId' => $userId]);
        $userAlreadyInGroup = $usersGroups->getData();

        if ($userAlreadyInGroup) {
            return true;
        }
        return false;
    }


    public static function validate()
    {
        $postData = self::convertPostToVariables();
        extract($postData);

        $emailIsExist = self::emailIsExistCheck($email);
        if (!$emailIsExist) {
            $userAlreadyInGroup = false;
        } else {
            $userAlreadyInGroup = self::userAlreadyInGroupCheck($email, $groupId);
        }

        echo (var_export($emailIsExist, true) . ' ' . var_export($userAlreadyInGroup, true));
        exit();
    }
}
