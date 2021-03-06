<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Repository\Interfaces\UserRepositoryInterface;

class AuthController extends Controller
{
 
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 
     * Register new user
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->create($request->email, $request->password);

        return response()->json(['data' => new UserResource($user)], 201);
    }


    /**
     * 
     * Login user
     */
    public function login(LoginRequest $request)
    {
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

    /**
     * 
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['data' => ['message' => 'User logged out successfully']], 200);
    }
}
