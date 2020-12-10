<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\User as UserResource;
use App\Repository\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(UserStoreRequest $request)
    {

        $validated = $request->validated();

        $user = $this->userRepository->create($request->email, $request->password);

        return response()->json(new UserResource($user), 201);
    }
}
