<?php

namespace Tests\Unit;

use App\Models\Item;
use PHPUnit\Framework\TestCase;

class ItemModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $item = new Item([
            'name' => 'Sample Item',
            'price' => 100,
            'description' => 'Sample description',
            'img_url' => 'http://example.com/image.jpg',
            'user_id' => 1,
            'category_item_id' => 1,
            'condition_id' => 1,
            'brand_id' => 1,
        ]);

        $this->assertEquals('Sample Item', $item->name);
        $this->assertEquals(100, $item->price);
        $this->assertEquals('Sample description', $item->description);
        $this->assertEquals('http://example.com/image.jpg', $item->img_url);
        $this->assertEquals(1, $item->user_id);
        $this->assertEquals(1, $item->category_item_id);
        $this->assertEquals(1, $item->condition_id);
        $this->assertEquals(1, $item->brand_id);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $item = new Item([
            'name' => 'Sample Item',
            'price' => 100,
            'description' => 'Sample description',
            'img_url' => 'http://example.com/image.jpg',
            'user_id' => 1,
            'category_item_id' => 1,
            'condition_id' => 1,
            'brand_id' => 1,
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $item->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $item = new Item();

        $this->assertTrue(method_exists($item, 'categoryItem'));
        $this->assertTrue(method_exists($item, 'condition'));
        $this->assertTrue(method_exists($item, 'user'));
        $this->assertTrue(method_exists($item, 'comments'));
        $this->assertTrue(method_exists($item, 'favorites'));
        $this->assertTrue(method_exists($item, 'soldItems'));
        $this->assertTrue(method_exists($item, 'paymentMethods'));
        $this->assertTrue(method_exists($item, 'brand'));
    }
}
