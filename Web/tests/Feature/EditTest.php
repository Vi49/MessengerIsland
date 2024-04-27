<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EditTest extends TestCase
{
    use TestHelperTrait;

    public function test_edit_bio(): void
    {
        $response = $this->post('/api/user/editBio', ['bio' => 'Test bio'], ['Authorization' => 'Bearer ' . $this->getTestJwtToken()]);

        $this->assertEquals('Success', $response->json()['message']);

        $response->assertStatus(200);
    }

    public function test_edit_first_name(): void
    {
        $response = $this->post('/api/user/editFirstName', ['first_name' => 'Emilia'], ['Authorization' => 'Bearer ' . $this->getTestJwtToken()]);

        $this->assertEquals('Success', $response->json()['message']);

        $response->assertStatus(200);
    }

    public function test_edit_last_name(): void
    {
        $response = $this->post('/api/user/editLastName', ['last_name' => 'Emilia'], ['Authorization' => 'Bearer ' . $this->getTestJwtToken()]);

        $this->assertEquals('Success', $response->json()['message']);

        $response->assertStatus(200);
    }

    public function test_edit_username(): void
    {
        $response = $this->post('/api/user/editUsername', ['username' => 'testusername98'], ['Authorization' => 'Bearer ' . $this->getTestJwtToken()]);

        $this->assertEquals('Success', $response->json()['message']);

        $response->assertStatus(200);
    }

    public function test_edit_avatar(): void
    {
        $avatar = UploadedFile::fake()->image('avatar.jpg', 250, 250);

        $response = $this->post('/api/user/editAvatar', ['avatar' => $avatar], ['Authorization' => 'Bearer ' . $this->getTestJwtToken()]);

        $this->assertEquals('Success', $response->json()['message']);

        $response->assertStatus(200);
    }
}
