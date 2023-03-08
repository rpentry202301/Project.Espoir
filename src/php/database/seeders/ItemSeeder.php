<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                [
                    'id'                    => '1',
                    'name'                  => 'こぉひぃ（S）',
                    'description'           => '苦みと酸味のバランスが素晴らしいコーヒーです。（Sサイズ）',
                    'secondary_category_id' => '1',
                    'price'                 => '200',
                    'image_file'            => 'drink_sample1.jpg'
                ], [
                    'id'                    => '2',
                    'name'                  => 'こぉひぃ（M）',
                    'description'           => '苦みと酸味のバランスが素晴らしいコーヒーです。（Mサイズ）',
                    'secondary_category_id' => '2',
                    'price'                 => '300',
                    'image_file'            => 'drink_sample2.jpg'
                ], [
                    'id'                    => '3',
                    'name'                  => 'こぉひぃ（L）',
                    'description'           => '苦みと酸味のバランスが素晴らしいコーヒーです。（Lサイズ）',
                    'secondary_category_id' => '3',
                    'price'                 => '400',
                    'image_file'            => 'drink_sample3.jpg'
                ], [
                    'id'                    => '4',
                    'name'                  => 'アイスティー（S）',
                    'description'           => 'さっぱり爽やかなアイスティーです。',
                    'secondary_category_id' => '1',
                    'price'                 => '200',
                    'image_file'            => 'drink_sample4.jpg'
                ], [
                    'id'                    => '5',
                    'name'                  => 'フレーバーアイスティー（M）',
                    'description'           => '期間限定フレーバーのアイスティーです。',
                    'secondary_category_id' => '2',
                    'price'                 => '450',
                    'image_file'            => 'drink_sample5.jpg'
                ], [
                    'id'                    => '6',
                    'name'                  => 'ミックスサンドイッチ',
                    'description'           => 'ハム、たまご、レタスの三種類が味わえるミックスサンドです。',
                    'secondary_category_id' => '6',
                    'price'                 => '300',
                    'image_file'            => 'food_sample1.jpg'
                ], [
                    'id'                    => '7',
                    'name'                  => 'こだわりたまごサンドイッチ',
                    'description'           => 'たまごをたっぷり使ったこだわりのサンドイッチです。',
                    'secondary_category_id' => '6',
                    'price'                 => '300',
                    'image_file'            => 'food_sample2.jpg'
                ], [
                    'id'                    => '8',
                    'name'                  => 'チョコケーキ',
                    'description'           => '濃厚なチョコケーキです。',
                    'secondary_category_id' => '5',
                    'price'                 => '450',
                    'image_file'            => 'sweets_sample1.jpg'
                ], [
                    'id'                    => '9',
                    'name'                  => 'モンブラン',
                    'description'           => '栗が濃厚なモンブランです。',
                    'secondary_category_id' => '5',
                    'price'                 => '350',
                    'image_file'            => 'sweets_sample2.jpg'
                ], [
                    'id'                    => '10',
                    'name'                  => 'シュークリーム',
                    'description'           => '自家製のクリームをたっぷり使ったシュークリームです。',
                    'secondary_category_id' => '5',
                    'price'                 => '500',
                    'image_file'            => 'sweets_sample3.jpg'
                ], [
                    'id'                    => '11',
                    'name'                  => 'ショートケーキ',
                    'description'           => 'イチゴが乗った、シンプル＆王道の人気NO.1商品です。',
                    'secondary_category_id' => '5',
                    'price'                 => '400',
                    'image_file'            => 'sweets_sample4.jpg'
                ]
            ]
        );
    }
}
