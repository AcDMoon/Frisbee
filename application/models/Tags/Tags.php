<?php

namespace Frisbee\models\Tags;

use Frisbee\core\model\Entities;

class Tags extends Entities
{
    public int $tagId;
    public string $tagName;
    public string $tagDescription;
    protected array $uniqueFields = ['tagId'];
}