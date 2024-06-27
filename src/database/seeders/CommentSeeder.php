<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $items = Item::all();

        $comments = [
            '購入を考えているのですが、こちらの商品はお値下げ可能でしょうか？',
            'いつ頃購入されたものでしょうか？',
            'コメント失礼いたします。商品の状態を確認させてください。',
            '複数購入を検討していますが、割引はありますか？',
            'こちらの商品は、いつ頃発送いただけますでしょうか？',
            'コメント失礼いたします。写真を追加していただけないでしょうか？',
            '使用感はどのような感じでしょうか？',
            'この商品は新品ですか？',
            'こちらの商品はまだ購入可能でしょうか？'
        ];

        foreach ($items as $item) {
            $randomUsers = $users->random(3);
            foreach ($randomUsers as $user) {
                Comment::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'comment' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}
