<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_toppings')->insert(
            [
                [
                    'order_item_id' => '1',
                    'topping_id'    => '1'
                ],
                [
                    'order_item_id' => '1',
                    'topping_id'    => '6'
                ]
            ]
        );
    }
}
