<?php

namespace Frisbee\models\BirthdayMonitoring;

use Frisbee\core\model\Entities;

class BirthdayMonitoring extends Entities
{
    protected string $tableName = 'BirthdayMonitoring';
    public int $userId;
    public int $monitoringId;
    protected array $uniqueFields = [];
}
