<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_toggle_favorite_adds_favorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('favorite.toggle', ['item' => $item->id]));

        $response->assertRedirect();
        $response->assertSessionHas('status', 'お気に入りに追加しました。');

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_toggle_favorite_removes_favorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->post(route('favorite.toggle', ['item' => $item->id]));

        $response->assertRedirect();
        $response->assertSessionHas('status', 'お気に入りを解除しました。');

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_destroy_removes_favorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete(route('favorite.destroy', ['item' => $item->id]));

        $response->assertRedirect();
        $response->assertSessionHas('status', 'お気に入りを解除しました。');

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
