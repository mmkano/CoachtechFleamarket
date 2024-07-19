<?php

use Tests\TestCase;

class AdminFeatureShowLoginFormTest extends TestCase
{
    public function testShowLoginForm()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin_login');
    }
}