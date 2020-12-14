<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('secret123456')
        ]);
        
        $response = $this->json('POST', '/api/login', [
            'email' => 'test@test.com',
            'password' => 'secret123456'
        ]);

        $response
            ->assertJsonStructure(['data', 'authToken'])
            ->assertJson([
                'data' => [
                    'email' => 'test@test.com'
                ]
            ])
            ->assertStatus(200);

        \Log::info(1, [$response->getContent()]);
    }


    /**
     * @test
     */
     public function login_requires_email_and_password()
     {
         $response = $this->json('POST', '/api/login', [
             'email' => '',
             'password' => ''
         ]);

         $response->assertJson([
                'errors' => [
                    'email' => ['Email is required'],
                    'password' => ['Password is required']
                ]
            ])
            ->assertStatus(422);
     }

     /**
      * @test
      */
      public function login_incorrect_email()
      {

        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('secret123456')
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'testt@test.com',
            'password' => 'secret123456'
        ]);

        $response
            ->assertJson([
                'errors' => 'Incorrect login details'
            ])
            ->assertStatus(422);
      }

    /**
      * @test
      */
      public function login_incorrect_password()
      {

        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('secret1234567')
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'test@test.com',
            'password' => 'secret123456'
        ]);

        $response
            ->assertJson([
                'errors' => 'Incorrect login details'
            ])
            ->assertStatus(422);
      }
}
