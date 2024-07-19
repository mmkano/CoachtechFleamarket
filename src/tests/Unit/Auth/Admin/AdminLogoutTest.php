<?php

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class AdminLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLogout()
    {
        $admin = Admin::factory()->create();
        Auth::guard('admin')->login($admin);

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertFalse(Auth::guard('admin')->check());
    }
}
