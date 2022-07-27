<?php

namespace App\Repositories\Contracts\Users;

use App\Models\User;

interface UserRepositoryInterface
{
    public function save(array $data): User;
}
