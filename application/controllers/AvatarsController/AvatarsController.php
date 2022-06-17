<?php

namespace Frisbee\controllers\AvatarsController;


use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class AvatarsController
{
    public static function getAvatar(string $avatarType, $objectId)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $defaultAvatars = IncludeOrRequireMethods::requireConfig('defaultAvatar.php');
        if ($avatarType == 'user') {
            $avatar = $defaultAvatars['defaultUserAvatar'];
            $pattern = '/^' . $objectId . '\./';
            $avatarsDirectory = 'profileAvatars/';
            foreach (scandir($avatarsDirectory) as $item => $value) {
                if (preg_match($pattern, $value)) {
                    $avatar = 'http://' . $domain['domain'] . '/' . $avatarsDirectory . $value . '?' . time();
                }
            }
            return $avatar;
        }
        if ($avatarType == 'group') {
            $avatar = $defaultAvatars['defaultGroupAvatar'];
            $pattern = '/^' . $objectId . '\./';
            $avatarsDirectory = 'groupAvatars/';
            foreach (scandir($avatarsDirectory) as $item => $value) {
                if (preg_match($pattern, $value)) {
                    $avatar = 'http://' . $domain['domain'] . '/' . $avatarsDirectory . $value . '?' . time();
                }
            }
            return $avatar;
        }
    }
}