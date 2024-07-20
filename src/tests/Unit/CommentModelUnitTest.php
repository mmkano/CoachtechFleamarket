<?php

namespace Tests\Unit;

use App\Models\Comment;
use PHPUnit\Framework\TestCase;

class CommentModelUnitTest extends TestCase
{
    public function test_fillable_attributes_are_set_correctly()
    {
        $comment = new Comment([
            'user_id' => 1,
            'item_id' => 2,
            'comment' => 'This is a test comment.',
        ]);

        $this->assertEquals(1, $comment->user_id);
        $this->assertEquals(2, $comment->item_id);
        $this->assertEquals('This is a test comment.', $comment->comment);
    }

    public function test_non_fillable_attributes_are_not_set()
    {
        $comment = new Comment([
            'user_id' => 1,
            'item_id' => 2,
            'comment' => 'This is a test comment.',
            'non_fillable' => 'test'
        ]);

        $this->assertArrayNotHasKey('non_fillable', $comment->getAttributes());
    }

    public function test_relationship_methods_exist()
    {
        $comment = new Comment();

        $this->assertTrue(method_exists($comment, 'user'));
        $this->assertTrue(method_exists($comment, 'item'));
    }
}
