<?php

namespace Frisbee\models\Taglist;

use Frisbee\core\model\Entities;

class Taglist extends Entities
{
    protected string $tableName = 'Taglist';
    public int $taglistId;
    public string $tagId;
    protected array $uniqueFields = [];
}