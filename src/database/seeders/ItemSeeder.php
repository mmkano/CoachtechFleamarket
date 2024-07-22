<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Brand;
use App\Models\User;

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
        $brands = Brand::all();
        $user = User::first();

        $items = [
            'ファッション' => [
                'name' => 'Tシャツ',
                'price' => 15000,
                'description' => '最新のトレンドを取り入れたファッションアイテムです。',
                'image_url' => 'fashion.jpg',
            ],
            'ベビー・キッズ' => [
                'name' => '可愛いベビー靴',
                'price' => 5000,
                'description' => '柔らかくて肌に優しい素材を使用したベビー靴です。',
                'image_url' => 'baby.jpg',
            ],
            'ゲーム・おもちゃ・グッズ' => [
                'name' => 'バスとロボット',
                'price' => 3000,
                'description' => 'かわいいバスとロボットのおもちゃセットです。',
                'image_url' => 'toy.jpg',
            ],
            'ホビー・楽器・アート' => [
                'name' => 'ウクレレ',
                'price' => 10000,
                'description' => '音色にこだわったプロ仕様の高級ウクレレです。',
                'image_url' => 'guitar.jpg',
            ],
            'チケット' => [
                'name' => '旅行チケット',
                'price' => 8000,
                'description' => '人気の旅行チケットです。',
                'image_url' => 'ticket.jpg',
            ],
            '本・雑誌・漫画' => [
                'name' => '最新ベストセラー本',
                'price' => 2000,
                'description' => '話題の最新ベストセラー本です。',
                'image_url' => 'book.jpg',
            ],
            'CD・DVD・ブルーレイ' => [
                'name' => '人気映画のブルーレイ',
                'price' => 3500,
                'description' => '話題の人気映画のブルーレイディスクです。',
                'image_url' => 'cd.jpg',
            ],
            'スマホ・タブレット・パソコン' => [
                'name' => '最新パソコン',
                'price' => 80000,
                'description' => '最新機能を搭載したパソコンです。',
                'image_url' => 'laptop.jpg',
            ],
            'テレビ・オーディオ・カメラ' => [
                'name' => '高画質カメラ',
                'price' => 150000,
                'description' => '鮮やかな映像を楽しめる高画質カメラです。',
                'image_url' => 'camera.jpg',
            ],
            '生活家電・空調' => [
                'name' => '最新洗濯機',
                'price' => 50000,
                'description' => '省エネ機能を搭載した最新洗濯機です。',
                'image_url' => 'laundry.jpg',
            ],
            'スポーツ' => [
                'name' => 'テニス用品セット',
                'price' => 10000,
                'description' => '人気のテニス用品をセットにしました。',
                'image_url' => 'sport.jpg',
            ],
            'アウトドア・釣り・旅行用品' => [
                'name' => 'キャンプ用品セット',
                'price' => 20000,
                'description' => 'キャンプに必要な用品を揃えたセットです。',
                'image_url' => 'tents.jpg',
            ],
            'コスメ・美容' => [
                'name' => 'メイクセット',
                'price' => 12000,
                'description' => '肌に優しいメイク商品のセットです。',
                'image_url' => 'cosmetics.jpg',
            ],
            'ダイエット・健康' => [
                'name' => '健康サプリメントセット',
                'price' => 8000,
                'description' => '健康維持に役立つサプリメントのセットです。',
                'image_url' => 'supplements.jpg',
            ],
            '食品・飲料・酒' => [
                'name' => 'コーヒー豆',
                'price' => 15000,
                'description' => '厳選されたコーヒー豆です。',
                'image_url' => 'coffee.jpg',
            ],
            'キッチン・日用品・その他' => [
                'name' => '洗剤セット',
                'price' => 10000,
                'description' => '掃除が楽しくなる洗剤のセットです。',
                'image_url' => 'detergents.jpg',
            ],
            '家具・インテリア' => [
                'name' => 'おしゃれな家具セット',
                'price' => 30000,
                'description' => '部屋をおしゃれにする家具のセットです。',
                'image_url' => 'interior.jpg',
            ],
            'ペット用品' => [
                'name' => 'ペットおやつ',
                'price' => 5000,
                'description' => '大切なペットのためのおやつセットです。',
                'image_url' => 'treats.jpg',
            ],
            'DIY・工具' => [
                'name' => 'DIY工具セット',
                'price' => 8000,
                'description' => 'DIYに必要な工具を揃えたセットです。',
                'image_url' => 'tool.jpg',
            ],
            'フラワー・ガーデニング' => [
                'name' => 'フラワーアレンジメント',
                'price' => 6000,
                'description' => 'トレンドの花束です。',
                'image_url' => 'flower.jpg',
            ],
            'ハンドメイド・手芸' => [
                'name' => 'ハンドメイド石鹸',
                'price' => 4000,
                'description' => '環境に良いハンドメイドの石鹸です。',
                'image_url' => 'handmade.jpg',
            ],
            '車・バイク・自転車' => [
                'name' => '最新自転車',
                'price' => 10000,
                'description' => '快適に乗れる自転車です。',
                'image_url' => 'bicycle.jpg',
            ]
        ];

        foreach ($items as $categoryName => $item) {
            $categoryItem = $categories->where('name', $categoryName)->first();
            if ($categoryItem) {
                $localPath = public_path('images/' . $item['image_url']);
                $s3Path = 'images/' . $item['image_url'];
                if (file_exists($localPath) && !Storage::disk('s3')->exists($s3Path)) {
                    Storage::disk('s3')->put($s3Path, file_get_contents($localPath));
                }

                Item::create([
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'img_url' => Storage::disk('s3')->url($s3Path),
                    'user_id' => $user->id,
                    'category_item_id' => $categoryItem->id,
                    'condition_id' => $conditions->random()->id,
                    'brand_id' => rand(0, 1) ? $brands->random()->id : null,
            }
        }
    }
}
