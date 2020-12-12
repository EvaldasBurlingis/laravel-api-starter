<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use App\Repository\Interfaces\UserRepositoryInterface;

class LoginController extends Controller
{
 
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {

        $validated = $request->validated();

        $user = $this->userRepository->find('email', $request->email);

        if( !$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => 'Incorrect login details'
            ], 422);
        }

        $authToken = $user->createToken('authToken')->plainTextToken;
        
        return response()->json([
            'data' => new UserResource($user),  
            'authToken' => $authToken
        ], 200);
    }
}
