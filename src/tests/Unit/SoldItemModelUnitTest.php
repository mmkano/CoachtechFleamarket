<?php

namespace Tests\Unit;

use App\Models\SoldItem;
use PHPUnit\Framework\TestCase;

class SoldItemModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $soldItem = new SoldItem([
            'item_id' => 1,
            'user_id' => 2,
        ]);

        $this->assertEquals(1, $soldItem->item_id);
        $this->assertEquals(2, $soldItem->user_id);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $soldItem = new SoldItem([
            'item_id' => 1,
            'user_id' => 2,
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $soldItem->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $soldItem = new SoldItem();

        $this->assertTrue(method_exists($soldItem, 'item'));
        $this->assertTrue(method_exists($soldItem, 'user'));
    }
}
