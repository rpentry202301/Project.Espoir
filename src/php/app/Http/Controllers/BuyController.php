<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;
use App\Models\OrderTopping;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class BuyController extends Controller
{
    public function showBuyForm()
    {
        // もし購入済みだったら404エラーに飛ばすような処理 → 今回の実装では使用しないかも。
        // if (!$item->isStateSelling) {
        //     abort(404);
        // }

        return view('buy-form');
    }

    public function buyOrderItems(Request $request)
    {

        //order_toppingをテーブルにinsert
        $orderTopping = new OrderTopping();
        $orderTopping->order_item_id = 1; #TODO order_itemsのidをもってくる

        //order_itemをテーブルにinsert
        $orderItem = new OrderItem();

        //orderをテーブルにinsert
        $order = new Order();
        $order->user_id = Auth::id();
        $order->delivery_destination_id; #TODO delivery_destinationsのidをもってくる。もしformで選択されていなかったらnullが入るようにする。
        $order->price_include_tax = $request->price_include_tax;
        $order->order_date = Carbon::now();
        $order->delivery_destination_name = $request->delivery_destination_name;
        $order->zipcode = $request->zipcode;
        $order->address = $request->address;
        $order->telephone = $request->telephone;
        $order->payment_method = $request->payment_method;
        $order->save();

        return redirect()->back()->with('status', '購入完了しました');
    }
}
