<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topping;


class OrderTopping extends Topping
{
    use HasFactory;

    public function csvHeader()
    {
        return [
            '注文商品ID',
            '名前',
            '',
            '',
            '商品価格'
        ];
    }
}
