<?php

namespace Tests\Feature\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_login()
    {

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
