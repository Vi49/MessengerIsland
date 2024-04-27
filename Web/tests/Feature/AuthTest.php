<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;

class AuthTest extends TestCase
{
    use TestHelperTrait;

    public function test_register_api(): void
    {
        $response = $this->post('/api/auth/register', ['email' => 'testuser@gmail.com', 'password'=> 't3stP4ssw0rd!Ok']);

        $response->assertStatus(200);
    }

    public function test_afterreg_api(): void
    {
        $jwtToken = $this->getTestJwtToken();

        $response = $this->post('/api/auth/afterreg', ['first_name' => 'John', 'last_name'=> 'Doe'], ['Authorization' => 'Bearer ' . $jwtToken]);

        $response->assertStatus(200);

        $this->assertEquals('Successfully after registered', $response->json()['message']);
    }
}
