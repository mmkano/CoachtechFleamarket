<?php

use Tests\TestCase;

class ShowLoginFormTest extends TestCase
{
    public function testShowLoginForm()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
}
