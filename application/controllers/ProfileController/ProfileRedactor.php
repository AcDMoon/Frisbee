<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\core\model\DB;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\User\User;

class ProfileRedactor
{
    private static $data = [];


    private static function deleteAvatar($id)
    {
        $pattern = '/^' . $id . '\./';
        $avatarsDirectory = 'profileAvatars/';
        foreach (scandir($avatarsDirectory) as $item => $value) {
            if (preg_match($pattern, $value)) {
                unlink($avatarsDirectory . $value);
            }
        }
    }

    private static function changeAvatar()
    {
        if (!isset(self::$data['avatar'])) {
            return;
        }
        $user = new User(['email' => self::$data['primalEmail']]);
        $userInfo = $user->getInfo(['userId']);
        $id = $userInfo[0];
        $imageType = explode('/', self::$data['avatar']['type'])[1];
        $newName = $id . '.' . $imageType;
        self::deleteAvatar($id);
        copy($_FILES['avatar']['tmp_name'], 'profileAvatars/' . $newName);
    }

    private static function changeName()
    {
        if (!isset(self::$data['name'])) {
            return;
        }
        $user = new User(['email' => self::$data['primalEmail'], 'name' => self::$data['name']]);
        $user->updateObject();
    }

    private static function changeDate()
    {
        if (!isset(self::$data['date'])) {
            return;
        }
        $user = new User(['email' => self::$data['primalEmail'], 'date' => self::$data['date']]);
        $user->updateObject();
    }

    private static function createGroup()
    {
        if (!isset(self::$data['newGroup'])) {
            return;
        }
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d', time());
        $group = new Groupss(['owners' => self::$data['primalEmail'], 'groupName' => self::$data['newGroup'], 'dateOfCreate' => $date]);
        $group->addInfo();

        $groupId = DB::getLastId();

        $user = new User(['email' => self::$data['primalEmail']]);
        $userId = $user->getInfo(['userId'])[0];

        $emailGroupTaglist = new EmailGroupTaglist(['userId' => $userId, 'groupId' => $groupId]);
        $emailGroupTaglist->addInfo();
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
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        header("Location: http://" . $domain['domain'] . "/profile");
    }
}
