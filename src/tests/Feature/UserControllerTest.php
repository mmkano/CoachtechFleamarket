<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\SoldItem;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_page_redirects_if_not_logged_in()
    {
        $response = $this->get(route('mypage'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'このページにアクセスするにはログインが必要です。');
    }

    public function test_my_page_shows_correct_data_if_logged_in()
    {
        $user = User::factory()->create();
        $items = Item::factory()->count(3)->create(['user_id' => $user->id]);
        $soldItems = SoldItem::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertViewIs('mypage');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('items', function ($viewItems) use ($items) {
            return $viewItems->pluck('id')->sort()->values()->all() === $items->pluck('id')->sort()->values()->all();
        });
        $response->assertViewHas('soldItems', function ($viewSoldItems) use ($soldItems) {
            return $viewSoldItems->pluck('id')->sort()->values()->all() === $soldItems->pluck('id')->sort()->values()->all();
        });
    }
}
