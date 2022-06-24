<?php

namespace Frisbee\models\EmailGroupTaglist;

use Frisbee\core\model\Entities;

class EmailGroupTaglist extends Entities
{
    protected string $tableName = 'EmailGroupTaglist';
    public int $userId;
    public int $groupId;
    public int $taglistId;
    protected array $uniqueFields = ['taglistId'];
}