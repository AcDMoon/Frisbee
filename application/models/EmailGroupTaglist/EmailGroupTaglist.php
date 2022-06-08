<?php

namespace Frisbee\models\EmailGroupTaglist;

use Frisbee\core\model\Entities;

class EmailGroupTaglist extends Entities
{
    private int $userId;
    private int $groupId;
    private int $taglistId;
    protected array $uniqueFields = ['taglistId'];
}