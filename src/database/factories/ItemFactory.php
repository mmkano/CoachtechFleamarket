<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence,
            'img_url' => $this->faker->imageUrl(),
            'user_id' => \App\Models\User::factory(),
            'category_item_id' => \App\Models\CategoryItem::factory(),
            'condition_id' => \App\Models\Condition::factory(),
            'brand_id' => \App\Models\Brand::factory(),
        ];
    }
}