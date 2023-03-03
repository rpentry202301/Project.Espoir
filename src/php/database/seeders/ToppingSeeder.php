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
                    'name'                  => 'ちょこちっぷ',
                    'description'           => 'サクサクの甘いチョコチップです',
                    'price'                 => '50',
                    'image_file'            => 'チョコチップ.png'
                ], [
                    'id'                    => '2',
                    'name'                  => 'きゃらめる',
                    'description'           => 'あま～いキャラメルです',
                    'price'                 => '80',
                    'image_file'            => 'キャラメル.png'
                ]
            ]
        );
    }
}
