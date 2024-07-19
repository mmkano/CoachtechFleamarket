<?php

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminFeatureLoginTest extends TestCase
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
        $this->assertAuthenticatedAs($admin, 'admin');
    }
}
