<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategoryItemSeeder::class,
            ConditionSeeder::class,
            ItemSeeder::class,
            CommentSeeder::class,
            FavoriteSeeder::class,
            AdminSeeder::class,
            BrandSeeder::class,
        ]);
    }
}
