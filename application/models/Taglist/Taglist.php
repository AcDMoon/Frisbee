<?php

namespace Frisbee\models\Taglist;

use Frisbee\core\model\Entities;

class Taglist extends Entities
{
    public int $taglistId;
    public string $tagId;
    protected array $uniqueFields = [];
}