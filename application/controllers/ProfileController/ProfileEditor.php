<?php

namespace Frisbee\controllers\ProfileController;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;
use Frisbee\core\model\DB;
use Frisbee\models\EmailGroupTaglist\EmailGroupTaglist;
use Frisbee\models\Groupss\Groupss;
use Frisbee\models\Owners\Owners;
use Frisbee\models\User\User;

class ProfileEditor
{
    private static $data = [];


    private static function convertPostAndFilesToVariables()
    {
        foreach ($_POST as $item => $value) {
            self::$data[$item] = $value;
        }
        self::$data['avatar'] = $_FILES['avatar'] ?? '';
    }


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
        if (!self::$data['avatar']) {
            return;
        }
        $user = new User(['email' => self::$data['primalEmail']]);
        $userData = $user->getData(['userId']);
        $id = $userData[0];
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
        $group = new Groupss(['groupName' => self::$data['newGroup'], 'dateOfCreate' => $date]);
        $group->addData();

        $groupId = DB::getLastId();

        $user = new User(['email' => self::$data['primalEmail']]);
        $userId = $user->getData(['userId'])[0];

        $emailGroupTaglist = new EmailGroupTaglist(['userId' => $userId, 'groupId' => $groupId]);
        $emailGroupTaglist->addData();

        $owners = new Owners(['userId' => $userId, 'groupId' => $groupId]);
        $owners->addData();
    }

    public static function editProfile()
    {
        self::convertPostAndFilesToVariables();
        self::changeAvatar();
        self::changeName();
        self::changeDate();
        self::createGroup();
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        header("Location: http://" . $domain['domain'] . "/profile");
    }
}
