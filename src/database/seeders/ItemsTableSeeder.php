<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'condition_id' => 1,
            'user_id' => 1,
            'image' => 'Armani_Mens_Clock.jpg',
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 2,
            'user_id' => 2,
            'image' => 'HDD_Hard_Disk.jpg',
            'name' => 'HDD',
            'brand' => '西芝',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 3,
            'user_id' => 3,
            'image' => 'onion.jpg',
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束セット'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 4,
            'user_id' => 3,
            'image' => 'leathershoes.jpg',
            'name' => '革靴',
            'brand' => '',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 1,
            'user_id' => 2,
            'image' => 'laptop.jpg',
            'name' => 'ノートPC',
            'brand' => '',
            'price' => 45000,
            'description' => '高性能なノートパソコン'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 2,
            'user_id' => 1,
            'image' => 'MIC.jpg',
            'name' => 'マイク',
            'brand' => 'なし',
            'price' => 8000,
            'description' => '高音質のレコーディング用のマイク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 3,
            'user_id' => 1,
            'image' => 'redbag.jpg',
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバック'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 4,
            'user_id' => 2,
            'image' => 'Tumbler.jpg',
            'name' => 'タンブラー',
            'brand' => 'なし',
            'price' => 500,
            'description' => '使いやすいタンブラー'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 1,
            'user_id' => 1,
            'image' => 'Coffee_Grinder.jpg',
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'price' => 4000,
            'description' => '手動のコーヒーミル'
        ];
        DB::table('items')->insert($param);

        $param = [
            'condition_id' => 2,
            'user_id' => 3,
            'image' => 'Makeup.jpg',
            'name' => 'メイクセット',
            'brand' => '',
            'price' => 2500,
            'description' => '便利なメイクアップセット'
        ];
        DB::table('items')->insert($param);
    }
}
