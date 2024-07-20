<?php

namespace Tests\Unit;

use App\Models\Admin;
use PHPUnit\Framework\TestCase;

class AdminModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->assertEquals('Admin User', $admin->name);
        $this->assertEquals('admin@example.com', $admin->email);
        $this->assertEquals('password123', $admin->password);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $admin->getAttributes());
    }

    public function test_hidden_attributes_are_hidden()
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'remember_token' => 'token123'
        ]);

        $adminArray = $admin->toArray();
        $this->assertArrayNotHasKey('password', $adminArray);
        $this->assertArrayNotHasKey('remember_token', $adminArray);
    }
}
