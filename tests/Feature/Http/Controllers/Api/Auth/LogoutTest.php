<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_logout()
    {

        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('secret123456')
        ]);

        $authToken = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .$authToken 
        ])->json('POST', '/api/logout');

        $response
            ->assertJson(['data' => [
                'message' => 'User logged out successfully']
                ])
            ->assertStatus(200);
    }
}
