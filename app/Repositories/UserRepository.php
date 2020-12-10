<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(String $email, String $password) {

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $user;
    }
}