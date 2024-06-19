<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = CategoryItem::all();
        $conditions = Condition::all();

        for ($i = 1; $i <= 10; $i++) {
            Item::create([
                'name' => '商品 ' . $i,
                'price' => rand(1000, 10000),
                'description' => 'これは商品 ' . $i . ' の説明です。',
                'img_url' => 'images/default.png',
                'user_id' => 1,
                'category_item_id' => $categories->random()->id,
                'condition_id' => $conditions->random()->id,
            ]);
        }
    }
}
