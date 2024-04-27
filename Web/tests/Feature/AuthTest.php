<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;

class AuthTest extends TestCase
{
    public function test_register_api(): void
    {
        $response = $this->post('/api/auth/register', ['email' => 'testuser@gmail.com', 'password'=> 't3stP4ssw0rd!Ok']);

        $response->assertStatus(200);
    }
}
