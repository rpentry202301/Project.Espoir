<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class OrderItem extends Item
{
    use HasFactory;

    public function csvHeader()
    {
        return [
            'ID',
            '商品名',
            '注文ID',
            'カスタム価格',
            '数量',
            '',
            '',
            '商品価格'
        ];
    }
}
