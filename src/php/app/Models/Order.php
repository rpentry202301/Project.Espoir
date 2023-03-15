<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function csvHeader()
    {
        return [
            'ID',
            'ユーザーID',
            '購入金額',
            '注文日',
            '配送先名',
            '郵便番号',
            '住所',
            '電話番号',
            '支払方法'
        ];
    }
}
