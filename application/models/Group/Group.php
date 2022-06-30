<?php

namespace Frisbee\models\Group;

use Frisbee\core\model\Entities;

class Group extends Entities
{
    protected string $tableName = 'Groupss';
    public int $groupId;
    public string $groupName;
    public string $owners;
    public string $dateOfCreate;
    public int $userValue;
    public string $isNewAvatar;
    protected array $uniqueFields = ['groupId'];
}