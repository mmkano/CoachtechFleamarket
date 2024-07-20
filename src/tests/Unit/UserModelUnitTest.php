<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $user = new User([
            'name' => 'Sample User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'first_login' => true,
            'profile_image' => 'sample_image.jpg',
            'postal_code' => '123-4567',
            'address' => 'Sample Address',
            'building_name' => 'Sample Building'
        ]);

        $this->assertEquals('Sample User', $user->name);
        $this->assertEquals('user@example.com', $user->email);
        $this->assertEquals('password123', $user->password);
        $this->assertEquals(true, $user->first_login);
        $this->assertEquals('sample_image.jpg', $user->profile_image);
        $this->assertEquals('123-4567', $user->postal_code);
        $this->assertEquals('Sample Address', $user->address);
        $this->assertEquals('Sample Building', $user->building_name);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $user = new User([
            'name' => 'Sample User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'remember_token' => 'token123'
        ]);

        $this->assertArrayNotHasKey('remember_token', $user->getAttributes());
    }

    public function test_hidden_attributes_are_hidden()
    {
        $user = new User([
            'name' => 'Sample User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'remember_token' => 'token123'
        ]);

        $userArray = $user->toArray();
        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    public function test_relationship_methods_exist()
    {
        $user = new User();

        $this->assertTrue(method_exists($user, 'comments'));
        $this->assertTrue(method_exists($user, 'items'));
        $this->assertTrue(method_exists($user, 'favorites'));
        $this->assertTrue(method_exists($user, 'soldItems'));
        $this->assertTrue(method_exists($user, 'paymentMethods'));
    }
}
