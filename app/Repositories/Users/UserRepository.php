<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Contracts\Users\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function save(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return $user;
    }
}
