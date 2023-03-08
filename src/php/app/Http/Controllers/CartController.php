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

        $priceIncludeTax = 0;
        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
            foreach ($orderItemList as $orderItem) {
                $priceIncludeTax += $orderItem->price;
            }
        } else {
            $orderItemList = array();
        }

        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
            foreach ($orderToppingList as $orderTopping) {
                $priceIncludeTax += $orderTopping->price;
            }
        } else {
            $orderToppingList = array();
        }

        //トッピングの一覧をDBから取得
        $query = Topping::query();
        $toppings = $query->get();

        return view('items.show_cart', ['orderItemList' => $orderItemList, 'toppings' => $toppings, 'orderToppingList' => $orderToppingList, 'priceIncludeTax' => $priceIncludeTax]);
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

        //カートに追加する商品を追加する
        $query = Item::query();
        $orderItem = new OrderItem();
        $orderItem = $query->where('id', $request->id)->first();
        $orderItem->customed_price = $orderItem->price;
        $orderItemList[] = $orderItem;
        $_SESSION['orderItemList'] = $orderItemList;

        //直前の画面に戻る
        return redirect()->back()->with('status', 'カートに追加しました');
    }

    public function deleteCartItem(Request $request)
    {
        session_start();
        //配列の添え字をリクエストで持ってくる。
        $index = $request->index;
        $orderItemList = $_SESSION['orderItemList'];
        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
        } else {
            $orderToppingList = array();
        }

        #TODO 削除実行。トッピングが追加されている連続した商品を、数字が小さい商品を消すと、2番目のトッピングが残ってしまう問題。
        for ($i = 0; $i < count($orderToppingList); $i++) {
            if ($orderToppingList[$i]->order_item_id == $index) {
                unset($orderToppingList[$i]);
            }
        }
        unset($orderItemList[$index]);

        //indexを詰める
        $orderToppingList = array_values($orderToppingList);
        $orderItemList = array_values($orderItemList);

        $_SESSION['orderItemList'] = $orderItemList;
        $_SESSION['orderToppingList'] = $orderToppingList;

        return redirect()->back()->with('status', 'カートから削除しました');;
    }

    public function customedPriceCalc(int $price, int $index)
    {
        $orderItemList = $_SESSION['orderItemList'];
        foreach ($orderItemList as $key => $orderItem) {
            if ($key == $index) {
                $orderItem->customed_price += $price;
            }
        }
        $_SESSION['orderItemList'] = $orderItemList;
        return;
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
            $orderTopping = $query->where('id', $toppingId)->first();
            $orderTopping->order_item_id = $request->index; //ここでorder_toppingsテーブルのorder_item_idを仮置きする。
            $this->customedPriceCalc($orderTopping->price, $request->index);
            $orderToppingList[] = $orderTopping;
        }

        #TODO トッピングの削除
        //

        $_SESSION['orderToppingList'] = $orderToppingList;

        return redirect()->back()->with(['status' => 'トッピングを追加しました']);
    }
}
