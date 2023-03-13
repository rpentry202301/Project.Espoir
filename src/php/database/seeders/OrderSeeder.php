<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert(
            [
                [
                    'id'                        => '1',
                    'user_id'                   => '1',
                    'price_include_tax'         => '1000',
                    'order_date'                =>  Carbon::now(),
                    'delivery_destination_name' => '自宅',
                    'zipcode'                   => '1000001',
                    'address'                   => '東京都千代田区千代田1-1',
                    'telephone'                 => '0332131111',
                    'payment_method'            => '1'
                ],
                [
                    'id'                        => '2',
                    'user_id'                   => '1',
                    'price_include_tax'         => '500',
                    'order_date'                => '2020-03-09',
                    'delivery_destination_name' => '職場',
                    'zipcode'                   => '1600022',
                    'address'                   => '東京都新宿区新宿4-3-25 TOKYU REIT新宿ビル8F',
                    'telephone'                 => '0366753638',
                    'payment_method'            => '2'
                ]
            ]
        );
    }
}
