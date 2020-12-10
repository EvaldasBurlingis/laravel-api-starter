<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function can_register_new_user()

    {
        // $this->withoutExceptionHandling();

        $response = $this->json('POST', '/api/register', [
            'email' => 'test@test.com',
            'password' => 'secret123456',
            'password_confirmation' => 'secret123456'
        ]);

        $response->assertJsonStructure([
            'email', 'created_at'
        ])
        ->assertJson([
            'email' => 'test@test.com'
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com'
        ]);

        \Log::info(1, [$response->getContent()]);
    }

    /**
     * @test
     */
    public function register_requires_email_and_password()
    {

        $response = $this->json('POST', '/api/register', [
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response
            ->assertJson([
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
    public function register_email_must_be_email_type()
    {

        $response = $this->json('POST', '/api/register', [
            'email' => 'test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response
            ->assertJson([
                'errors' => [
                    'email' => ['Invalid email address']
                ]
            ])
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function register_email_must_be_unique()
    {

        $user = User::factory()->create([
            'email' => 'test@mail.com'
        ]);

        $response = $this->json('POST', '/api/register', [
            'email' => 'test@mail.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response
            ->assertJson([
                'errors' => [
                    'email' => ['Email is already registered']
                ]
            ])
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function register_password_and_password_confirmation_must_match()
    {
        $response = $this->json('POST', '/api/register', [
            'email' => 'test@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123456'
        ]);

        $response
            ->assertJson([
                'errors' => [
                    'password' => ['Password confirmation does not match']
                ]
            ])
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function register_password_must_be_at_lest_8_characters()
    {
        $response = $this->json('POST', '/api/register', [
            'email' => 'test@test.com',
            'password' => '1234567',
            'password_confirmation' => '1234567'
        ]);

        $response
            ->assertJson([
                'errors' => [
                    'password' => ['Password must be between 8-32 characters']
                ]
            ])
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function register_password_must_be_less_than_32_characters()
    {
        $response = $this->json('POST', '/api/register', [
            'email' => 'test@test.com',
            'password' => '123456789121581518451548fadsadasd66d4sa6d4as864d',
            'password_confirmation' => '123456789121581518451548fadsadasd66d4sa6d4as864d'
        ]);

        $response
            ->assertJson([
                'errors' => [
                    'password' => ['Password must be between 8-32 characters']
                ]
            ])
            ->assertStatus(422);
    }


}
