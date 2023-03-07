<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;
use App\Models\OrderTopping;


class CartController extends Controller
{
    public function showCartItem()
    {
        // 既にカートに商品が存在しているかどうか判別。
        session_start();
        //セッションを切りたくなったら
        // unset($_SESSION["orderItemList"]);
        // unset($_SESSION["orderToppingList"]);

        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
        } else {
            $orderItemList = array();
        }

        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
        } else {
            $orderToppingList = array();
        }

        //トッピングの一覧をDBから取得
        $query = Topping::query();
        $toppings = $query->get();

        return view('items.show_cart', ['orderItemList' => $orderItemList, 'toppings' => $toppings, 'orderToppingList' => $orderToppingList]);
    }

    public function addCartItem(Request $request)
    {
        // 既にカートに商品が存在しているかどうか判別。
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
        var_dump($index);
        $orderItemList = $_SESSION['orderItemList'];
        $orderToppingList = $_SESSION['orderToppingList'];

        //削除実行
        for ($i = 0; $i < count($orderToppingList); $i++) {
            if ($orderToppingList[$i]->order_item_id == $index) {
                unset($orderToppingList[$i]);
            }
        }
        unset($orderItemList[$index]);

        //indexを詰める
        $orderItemList = array_values($orderItemList);
        $orderToppingList = array_values($orderToppingList);

        $_SESSION['orderItemList'] = $orderItemList;
        $_SESSION['orderToppingList'] = $orderToppingList;

        return redirect()->back();
    }

    public function addCartTopping(Request $request)
    {
        session_start();

        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
        } else {
            $orderToppingList = array();
        }

        #TODO バリデーション：トッピングが何も選択されていない状態で「トッピングを追加」を押したとき
        //案：引数にOrderToppingRequestのフォームを作成し、nullを許容しない設定にする。

        # TODO トッピングの重複処理
        $orderTopping = new OrderTopping();
        foreach ($request->topping as $toppingId) {
            $query = Topping::query();
            $orderTopping = $query->where('id', $toppingId)->get();
            $orderTopping->order_item_id = $request->index; //ここでorder_toppingsテーブルのorder_item_idを仮置きする。購入時点で実際のorder_itemのIDを入れる。
            $orderToppingList[] = $orderTopping;
        }

        $_SESSION['orderToppingList'] = $orderToppingList;

        return redirect()->back()->with('orderToppingList', $orderToppingList);
    }
}
