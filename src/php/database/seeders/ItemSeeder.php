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
                    'image_file'            => 'コーヒー（S）.png'
                ], [
                    'id'                    => '2',
                    'name'                  => 'こぉひぃ（M）',
                    'description'           => '苦みと酸味のバランスが素晴らしいコーヒーです。（Mサイズ）',
                    'secondary_category_id' => '1',
                    'price'                 => '300',
                    'image_file'            => 'コーヒー（M）.png'
                ], [
                    'id'                    => '3',
                    'name'                  => 'こぉひぃ（L）',
                    'description'           => '苦みと酸味のバランスが素晴らしいコーヒーです。（Lサイズ）',
                    'secondary_category_id' => '1',
                    'price'                 => '400',
                    'image_file'            => 'コーヒー（L）.png'
                ]
            ]
        );
    }
}
