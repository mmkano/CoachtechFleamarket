<?php

namespace Tests\Unit;

use App\Models\Brand;
use PHPUnit\Framework\TestCase;

class BrandModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $brand = new Brand([
            'name' => 'Nike',
        ]);

        $this->assertEquals('Nike', $brand->name);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $brand = new Brand([
            'name' => 'Nike',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $brand->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $brand = new Brand();

        $this->assertTrue(method_exists($brand, 'items'));
    }
}
