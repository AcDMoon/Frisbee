<?php

namespace application\controllers\AvatarsController;


class AvatarsController
{
    public static function getAvatar(string $avatarType, $objectId)
    {
        $defaultAvatars = require 'application/config/defaultAvatar.php';
        if ($avatarType = 'user') {
            $avatar = $defaultAvatars['defaultUserAvatar'];
            $pattern = '/^' . $objectId . '\./';
            $avatarsDirectory = 'application/lib/profileAvatars/';
            foreach (scandir($avatarsDirectory) as $item => $value) {
                if (preg_match($pattern, $value)) {
                    $avatar = $avatarsDirectory . $value;
                }
            }
            return $avatar;
        }
    }
}