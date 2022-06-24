<?php

namespace Frisbee\controllers\AvatarsController;


use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

class AvatarsController
{
    public static function getAvatar(string $avatarType, $objectId)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $defaultAvatars = IncludeOrRequireMethods::requireConfig('defaultAvatar.php');
        $pattern = '/^' . $objectId . '\./';
        $avatar = $defaultAvatars['defaultAvatar'];
        if ($avatarType == 'user') {
            $avatarsDirectory = 'profileAvatars/';
        }
        if ($avatarType == 'group') {
            $avatarsDirectory = 'groupAvatars/';
        }
        foreach (scandir($avatarsDirectory) as $item => $value) {
            if (preg_match($pattern, $value)) {
                $avatar = 'http://' . $domain['domain'] . '/' . $avatarsDirectory . $value . '?' . time();
            }
        }
        return $avatar;
    }
}