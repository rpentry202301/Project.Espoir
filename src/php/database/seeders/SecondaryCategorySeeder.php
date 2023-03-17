<?php

namespace Database\Seeders;

use App\Models\SecondaryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secondary_categories')->insert(
            [
                [
                    'id'                  => '1',
                    'primary_category_id' => '1',
                    'name'                => 'Sサイズ'
                ], [
                    'id'                  => '2',
                    'primary_category_id' => '1',
                    'name'                => 'Mサイズ'
                ], [
                    'id'                  => '3',
                    'primary_category_id' => '1',
                    'name'                => 'Lサイズ'
                ], [
                    'id'                  => '4',
                    'primary_category_id' => '2',
                    'name'                => 'クッキー'
                ], [
                    'id'                  => '5',
                    'primary_category_id' => '2',
                    'name'                => 'ケーキ'
                ], [
                    'id'                  => '6',
                    'primary_category_id' => '3',
                    'name'                => 'サンドイッチ'
                ], [
                    'id'                  => '7',
                    'primary_category_id' => '3',
                    'name'                => 'ピッツァ'
                ]
            ]
        );
    }
}
