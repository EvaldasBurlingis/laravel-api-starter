<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(String $email, String $password) : User {

        return User::create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    public function find(String $key, String $value) : ?User {
        
        return User::where($key, $value)->first();

    }
}