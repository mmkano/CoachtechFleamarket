<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $response = $this->post(route('register'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }
}
