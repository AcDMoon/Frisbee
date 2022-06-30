<?php

namespace Frisbee\models\TagList;

use Frisbee\core\model\Entities;

class TagList extends Entities
{
    protected string $tableName = 'Taglist';
    public int $taglistId;
    public string $tagId;
    protected array $uniqueFields = [];
}