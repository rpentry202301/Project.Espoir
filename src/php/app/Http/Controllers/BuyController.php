<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;
use App\Models\OrderTopping;

class BuyController extends Controller
{
    public function showBuyForm(Request $request)
    {
        // もし購入済みだったら404エラーに飛ばすような処理 → 今回の実装では使用しないかも。
        // if (!$item->isStateSelling) {
        //     abort(404);
        // }

        return view('buy-form');
    }
}
