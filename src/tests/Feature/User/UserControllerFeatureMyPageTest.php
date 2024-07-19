<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class UserControllerFeatureMyPageTest extends TestCase
{
    use RefreshDatabase;

    public function testMyPage()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->andReturn($user);
        Auth::shouldReceive('check')->andReturn(true);

        $items = Item::factory()->count(3)->create(['user_id' => $user->id]);
        $soldItems = SoldItem::factory()->count(2)->create(['user_id' => $user->id, 'item_id' => $items->first()->id]);

        $response = $this->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertViewHas('user', $user);

        $response->assertViewHas('items', function ($viewItems) use ($items) {
            return $viewItems->pluck('id')->toArray() === $items->pluck('id')->toArray();
        });
        $response->assertViewHas('soldItems', function ($viewSoldItems) use ($soldItems) {
            return $viewSoldItems->pluck('UniqueID')->toArray() === $soldItems->pluck('UniqueID')->toArray();
        });
    }
}
