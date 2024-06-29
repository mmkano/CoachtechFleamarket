<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        $users = User::all();

        foreach ($items as $item) {
            $randomUsers = $users->random(3);
            foreach ($randomUsers as $user) {
                Favorite::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                ]);
            }
        }
    }
}
