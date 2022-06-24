<?php

namespace Frisbee\models\Groupss;

use Frisbee\core\model\Entities;

class Groupss extends Entities
{
    public int $groupId;
    public string $groupName;
    public string $owners;
    public string $dateOfCreate;
    public int $userValue;
    public string $isNewAvatar;
    protected array $uniqueFields = ['groupId'];
}