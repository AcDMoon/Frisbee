<?php

namespace Frisbee\models\Owners;

use Frisbee\core\model\Entities;

class Owners extends Entities
{
    protected string $tableName = 'Owners';
    public int $groupId;
    public string $userId;
    protected array $uniqueFields = [];
}