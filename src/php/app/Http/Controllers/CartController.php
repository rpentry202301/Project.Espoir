<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;


class CartController extends Controller
{
    public function showCartItem()
    {
        // 既にカートに商品が存在しているかどうか判別。この処理が必要かどうか怪しい。
        session_start();
        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
        } else {
            $orderItemList = array();
        }

        //トッピングの一覧をDBから取得
        $query = Topping::query();
        $toppings = $query->get();

        return view('items.show_cart', ['orderItemList' => $orderItemList, 'toppings' => $toppings]);
    }

    public function addCartItem(Request $request)
    {
        // 既にカートに商品が存在しているかどうか判別。この処理が必要かどうか怪しい。
        session_start();
        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
        } else {
            $orderItemList = array();
        }

        #TODO 一旦idの1が入るように設定。後でRequestで送られてくるItemのIDを取得するように編集予定
        $request->id = 1;

        //カートに追加する商品を追加する
        $query = Item::query();
        $orderItem = new OrderItem();
        $orderItem = $query->where('id', $request->id)->get();
        $orderItemList[] = $orderItem;
        $_SESSION['orderItemList'] = $orderItemList;

        //直前の画面に戻る
        return redirect()->back();
    }

    public function deleteCartItem(Request $request)
    {
        session_start();
        //配列の添え字をリクエストで持ってくる。
        $index = $request->index;
        $orderItemList = $_SESSION['orderItemList'];

        //削除実行
        unset($orderItemList[$index]);

        //indexを詰める
        $orderItemList = array_values($orderItemList);
        $_SESSION['orderItemList'] = $orderItemList;

        return redirect()->back();
    }

    public function addCartTopping(Request $request)
    {
        foreach ($request->topping as $topping) {
        }
        return redirect()->back();
    }
}
