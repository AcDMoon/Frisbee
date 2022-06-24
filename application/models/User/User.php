<?php

namespace Frisbee\models\User;

use Frisbee\core\model\Entities;

class User extends Entities
{
    public int $userId;
    public string $email;
    public string $password;
    public string $name;
    public bool $siteRole;
    public string $date;
    public string $hash;
    public bool $verification;
    public string $isNewAvatar;
    protected array $uniqueFields = ['userId', 'email', 'hash'];
}
