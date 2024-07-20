<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'Klarity (クラリティ)',
            'Zenth (ゼンス)',
            'Frostine (フロスティン)',
            'Lunaris (ルナリス)',
            'Velocia (ヴェロシア)',
            'NimbleNest (ニンブルネスト)',
            'Glacia (グラシア)',
            'Aurorise (オーロライズ)',
            'Driftwood (ドリフトウッド)',
            'Nebulon (ネビュロン)'
        ];

        foreach ($brands as $brand) {
            Brand::create(['name' => $brand]);
        }
    }
}
