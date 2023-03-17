<?php

namespace Database\Seeders;

use App\Models\PrimaryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PrimaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'id'   => '1',
                'name' => 'ドリンク'
            ], [
                'id'   => '2',
                'name' => 'スイーツ'
            ], [
                'id'   => '3',
                'name' => 'デリカ'
            ]
        ]);
    }
}
