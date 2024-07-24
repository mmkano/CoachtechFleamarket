<?php

namespace Tests\Unit;

use App\Models\Favorite;
use PHPUnit\Framework\TestCase;

class FavoriteModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $favorite = new Favorite([
            'user_id' => 1,
            'item_id' => 2,
        ]);

        $this->assertEquals(1, $favorite->user_id);
        $this->assertEquals(2, $favorite->item_id);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $favorite = new Favorite([
            'user_id' => 1,
            'item_id' => 2,
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $favorite->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $favorite = new Favorite();

        $this->assertTrue(method_exists($favorite, 'user'));
        $this->assertTrue(method_exists($favorite, 'item'));
    }
}
