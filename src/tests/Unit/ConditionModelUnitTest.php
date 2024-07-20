<?php

namespace Tests\Unit;

use App\Models\Condition;
use PHPUnit\Framework\TestCase;

class ConditionModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $condition = new Condition([
            'name' => 'New',
        ]);

        $this->assertEquals('New', $condition->name);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $condition = new Condition([
            'name' => 'New',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $condition->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $condition = new Condition();

        $this->assertTrue(method_exists($condition, 'items'));
    }
}
