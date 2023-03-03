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
                    'name'                => 'Sさいず'
                ], [
                    'id'                  => '2',
                    'primary_category_id' => '1',
                    'name'                => 'Mさいず'
                ], [
                    'id'                  => '3',
                    'primary_category_id' => '1',
                    'name'                => 'Lさいず'
                ], [
                    'id'                  => '4',
                    'primary_category_id' => '2',
                    'name'                => 'くっきぃ'
                ], [
                    'id'                  => '5',
                    'primary_category_id' => '2',
                    'name'                => 'けぇき'
                ], [
                    'id'                  => '6',
                    'primary_category_id' => '3',
                    'name'                => 'さんどいっち'
                ], [
                    'id'                  => '7',
                    'primary_category_id' => '3',
                    'name'                => 'ぴっつぁ'
                ]
            ]
        );
    }
}
