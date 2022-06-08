<?php

namespace Frisbee\controllers\AvatarsController;


use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class AvatarsController
{
    public static function getAvatar(string $avatarType, $objectId)
    {
        $defaultAvatars = IncludeOrRequireMethods::requireConfig('defaultAvatar.php');
        if ($avatarType = 'user') {
            $avatar = $defaultAvatars['defaultUserAvatar'];
            $pattern = '/^' . $objectId . '\./';
            $avatarsDirectory = 'profileAvatars/';
            foreach (scandir($avatarsDirectory) as $item => $value) {
                if (preg_match($pattern, $value)) {
                    $avatar = $avatarsDirectory . $value;
                }
            }
            return $avatar;
        }
    }
}