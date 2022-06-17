<?php

namespace Frisbee\models\GroupsInvites;

use Frisbee\core\model\Entities;

class GroupsInvites extends Entities
{
    public int $groupId;
    public int $userId;
    public string $hash;
    protected array $uniqueFields = ['hash'];
}