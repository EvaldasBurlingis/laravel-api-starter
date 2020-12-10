<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
   public function create(String $email, String $password) : Model;
}
