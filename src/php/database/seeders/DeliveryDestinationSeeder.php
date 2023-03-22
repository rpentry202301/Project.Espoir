<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_destinations')->insert(
            [
                [
                    'id'                        => '1',
                    'user_id'                   => '2',
                    'delivery_destination_name' => '自宅',
                    'zipcode'                   => '1111111',
                    'address'                   => '東京都新宿区新宿1-1-1',
                    'telephone'                 => '0901111111'
                ],
                [
                    'id'                        => '2',
                    'user_id'                   => '2',
                    'delivery_destination_name' => '会社',
                    'zipcode'                   => '2222222',
                    'address'                   => '東京都新宿区新宿2-2-2',
                    'telephone'                 => '0111011111'
                ],
                [
                    'id'                        => '3',
                    'user_id'                   => '2',
                    'delivery_destination_name' => '実家',
                    'zipcode'                   => '3333333',
                    'address'                   => '東京都新宿区新宿3-3-3',
                    'telephone'                 => '0903333333'
                ],
                [
                    'id'                        => '4',
                    'user_id'                   => '1',
                    'delivery_destination_name' => '管理室',
                    'zipcode'                   => '4444444',
                    'address'                   => '東京都新宿区新宿4-4-4',
                    'telephone'                 => '0904444444'
                ]
            ]
        );
    }
}
