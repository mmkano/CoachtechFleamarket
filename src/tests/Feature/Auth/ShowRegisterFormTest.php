<?php

use Tests\TestCase;

class ShowRegisterFormTest extends TestCase
{
    public function testShowRegisterForm()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
}
