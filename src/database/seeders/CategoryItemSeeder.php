<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryItem;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '洋服', '靴', '小物', '写真たて', 'バッグ', 'アクセサリー', '時計', '財布', '家具', '家電'
        ];

        foreach ($categories as $category) {
            CategoryItem::create(['name' => $category]);
        }
    }
}
