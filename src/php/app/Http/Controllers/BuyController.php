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
use Illuminate\Support\Facades\DB;

class BuyController extends Controller
{
    public function showBuyForm()
    {
        // もし購入済みだったら404エラーに飛ばすような処理 → 今回の実装では使用しないかも。
        // if (!$item->isStateSelling) {
        //     abort(404);
        // }

        unset($_SESSION["orderItemList"]);
        unset($_SESSION["orderToppingList"]);

        return view('buy-form');
    }

    public function buyOrderItems(Request $request)
    {

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

        //order_itemをテーブルにinsert。orderItemListを1回回している中に、orderToppingListをn回回す必要があると思う。
        $orderItem = new OrderItem();
        $orderItem->item_id = $request->item_id;
        $orderItem->order_id = DB::table('orders')->latest('id')->value('id');
        $orderItem->customed_price = $request->customed_price;
        $orderItem->quantity = $request->quantity;
        $orderItem->save();

        //order_toppingをテーブルにinsert
        $orderTopping = new OrderTopping();
        $orderTopping->order_item_id = DB::table('order_items')->latest('id')->value('id');
        $orderTopping->topping_id = $request->topping_id;
        $orderTopping->save();

        //セッションを切って、カートの中を空にする
        // unset($_SESSION["orderItemList"]);
        // unset($_SESSION["orderToppingList"]);

        return redirect()->back()->with('status', '購入完了しました');
    }
}
