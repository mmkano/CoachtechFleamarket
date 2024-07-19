<?php

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.users'));
        $this->assertTrue(Auth::guard('admin')->check());
    }
}
