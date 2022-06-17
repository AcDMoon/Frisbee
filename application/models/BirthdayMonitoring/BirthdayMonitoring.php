<?php

namespace Frisbee\models\BirthdayMonitoring;

use Frisbee\core\model\Entities;

class BirthdayMonitoring extends Entities
{
    public int $userId;
    public int $monitoringId;
    protected array $uniqueFields = [];
}
