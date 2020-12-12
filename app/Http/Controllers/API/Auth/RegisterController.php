<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Repository\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(RegisterRequest $request)
    {

        $validated = $request->validated();

        $user = $this->userRepository->create($request->email, $request->password);

        return response()->json(['data' => new UserResource($user)], 201);
    }
}
