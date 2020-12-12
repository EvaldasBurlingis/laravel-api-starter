<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
   public function create(String $email, String $password) : Model;
   
   public function find(String $key, String $value) : ?Model;

}
