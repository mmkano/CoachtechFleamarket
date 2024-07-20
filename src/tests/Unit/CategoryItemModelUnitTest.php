<?php

namespace Tests\Unit;

use App\Models\CategoryItem;
use PHPUnit\Framework\TestCase;

class CategoryItemModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $category = new CategoryItem([
            'name' => 'Electronics',
        ]);

        $this->assertEquals('Electronics', $category->name);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $category = new CategoryItem([
            'name' => 'Electronics',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $category->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $category = new CategoryItem();

        $this->assertTrue(method_exists($category, 'items'));
    }
}
