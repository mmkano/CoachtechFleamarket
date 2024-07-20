<?php

namespace Tests\Unit;

use App\Models\UserItemPaymentMethod;
use PHPUnit\Framework\TestCase;

class UserItemPaymentMethodModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $paymentMethod = new UserItemPaymentMethod([
            'user_id' => 1,
            'item_id' => 2,
            'payment_method' => 'credit_card',
        ]);

        $this->assertEquals(1, $paymentMethod->user_id);
        $this->assertEquals(2, $paymentMethod->item_id);
        $this->assertEquals('credit_card', $paymentMethod->payment_method);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $paymentMethod = new UserItemPaymentMethod([
            'user_id' => 1,
            'item_id' => 2,
            'payment_method' => 'credit_card',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $paymentMethod->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $paymentMethod = new UserItemPaymentMethod();

        $this->assertTrue(method_exists($paymentMethod, 'user'));
        $this->assertTrue(method_exists($paymentMethod, 'item'));
    }
}
