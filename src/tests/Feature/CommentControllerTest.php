<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_comments_redirects_if_not_logged_in()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('comments.show', ['id' => $item->id]));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'コメントを見るにはログインしてください。');
    }

    public function test_show_comments_shows_comments_if_logged_in()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $comments = Comment::factory()->count(3)->create(['item_id' => $item->id]);

        $response = $this->actingAs($user)->get(route('comments.show', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertViewIs('comment');
        $response->assertViewHas('comments', function ($viewComments) use ($comments) {
            return $viewComments->pluck('id')->sort()->values()->all() === $comments->pluck('id')->sort()->values()->all();
        });
    }

    public function test_submit_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.submit', ['id' => $item->id]), [
            'comment' => 'Test Comment'
        ]);

        $response->assertRedirect(route('comments.show', ['id' => $item->id]));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'Test Comment'
        ]);
    }

    public function test_delete_comment_as_authorized_user()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete(route('comments.delete', ['item' => $item->id, 'comment' => $comment->id]));

        $response->assertRedirect(route('comments.show', ['id' => $item->id]));
        $response->assertSessionHas('status', 'コメントを削除しました。');
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_delete_comment_as_unauthorized_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete(route('comments.delete', ['item' => $item->id, 'comment' => $comment->id]));

        $response->assertRedirect(route('comments.show', ['id' => $item->id]));
        $response->assertSessionHas('error', '権限がありません。');
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }
}
