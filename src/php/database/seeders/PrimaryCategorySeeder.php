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
                'name' => 'どりんく'
            ], [
                'id'   => '2',
                'name' => 'すいぃつ'
            ], [
                'id'   => '3',
                'name' => 'でりか'
            ]
        ]);
    }
}
