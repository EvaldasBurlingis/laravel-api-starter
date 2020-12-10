<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(String $email, String $password) : User {

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $user;
    }
}