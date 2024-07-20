<?php

namespace Database\Factories;

use App\Models\SoldItem;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoldItemFactory extends Factory
{
    protected $model = SoldItem::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
        ];
    }
}
