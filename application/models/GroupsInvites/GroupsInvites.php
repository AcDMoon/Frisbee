<?php

namespace Frisbee\models\GroupsInvites;

use Frisbee\core\model\Entities;

class GroupsInvites extends Entities
{
    protected string $tableName = 'GroupsInvites';
    public int $groupId;
    public int $userId;
    public string $hash;
    protected array $uniqueFields = ['hash'];
}