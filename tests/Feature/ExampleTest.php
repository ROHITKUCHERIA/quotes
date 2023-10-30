<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;



class ExampleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_login()
    {
        $password = 'your-test-password';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(302);

        $this->assertGuest();
    }
}
