<?php

namespace Tests\Feature;

trait TestHelperTrait
{
    public function getTestJwtToken()
    {
        $email = 'testuser@gmail.com';
        $password = 't3stP4ssw0rd!Ok';

        // Make a request to register or authenticate and obtain the JWT token
        $response = $this->json('POST', '/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        // Assert that the registration or authentication was successful
        $response->assertStatus(200);

        // Decode the JSON response to get the token
        return $response->json()['access_token'];
    }


}
