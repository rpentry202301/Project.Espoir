<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('toppings')->insert(
            [
                [
                    'id'                    => '1',
                    'name'                  => 'チョコチップ',
                    'description'           => 'サクサクの甘いチョコチップです',
                    'price'                 => '50',
                    'image_file'            => 'topping_sample1.jpg'
                ], [
                    'id'                    => '2',
                    'name'                  => 'キャラメル',
                    'description'           => 'あま～いキャラメルです',
                    'price'                 => '80',
                    'image_file'            => 'topping_sample2.jpg'
                ], [
                    'id'                    => '3',
                    'name'                  => 'レモンシロップ',
                    'description'           => '自家製シロップです',
                    'price'                 => '80',
                    'image_file'            => 'topping_sample.jpg'
                ], [
                    'id'                    => '4',
                    'name'                  => '黒蜜',
                    'description'           => '甘いのがお好きな方におすすめです',
                    'price'                 => '80',
                    'image_file'            => 'topping_sample4.jpg'
                ],
                [
                    'id'                    => '5',
                    'name'                  => '紅茶シロップ',
                    'description'           => '良い香りがします',
                    'price'                 => '80',
                    'image_file'            => 'topping_sample5.jpg'
                ],
                [
                    'id'                    => '6',
                    'name'                  => '生クリーム',
                    'description'           => '甘すぎず、滑らかな生クリームです',
                    'price'                 => '100',
                    'image_file'            => 'topping_sample6.jpg'
                ],
                [
                    'id'                    => '7',
                    'name'                  => 'はちみつ',
                    'description'           => 'どんな飲み物にも合います',
                    'price'                 => '80',
                    'image_file'            => 'topping_sample7.jpg'
                ]
            ]
        );
    }
}
