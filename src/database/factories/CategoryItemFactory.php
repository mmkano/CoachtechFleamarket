<?php

namespace Database\Factories;

use App\Models\CategoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryItemFactory extends Factory
{
    protected $model = CategoryItem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}