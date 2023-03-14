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
                $priceIncludeTax += $orderItem->customed_price * $orderItem->quantity;
            }
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

        if (isset($_SESSION['itemIdList'])) {
            $itemIdList = $_SESSION['itemIdList'];
        } else {
            $itemIdList = array();
        }

        //カートに追加する商品を追加する
        $query = Item::query();
        $orderItem = new OrderItem();
        $orderItem = $query->where('id', $request->id)->first();
        $orderItem->id = time();
        $orderItem->item_id = $query->where('id', $request->id)->value('id');
        $orderItem->customed_price = $orderItem->price;
        $orderItem->quantity = 1;
        $orderItemList[] = $orderItem;
        $_SESSION['orderItemList'] = $orderItemList;

        //Itemのidが要素の配列をセッションに入れる
        $itemIdList[] = $query->where('id', $request->id)->value('id');
        $_SESSION['itemIdList'] = $itemIdList;

        //直前の画面に戻る
        return redirect()->back()->with('status', 'カートに追加しました');
    }

    public function deleteCartItem(Request $request)
    {
        session_start();

        //配列の添え字をリクエストで持ってくる。
        $index = (int)$request->index;

        $orderItemList = $_SESSION['orderItemList'];
        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
        } else {
            $orderToppingList = array();
        }

        foreach ($orderToppingList as $key => $orderTopping) {
            if ($orderTopping->order_item_id == $index) {
                unset($orderToppingList[$key]);
            }
        }

        foreach ($orderItemList as $key => $orderItem) {
            if ($orderItem->id == $index) {
                unset($orderItemList[$key]);
            }
        }

        //indexを詰める
        $orderToppingList = array_values($orderToppingList);
        $orderItemList = array_values($orderItemList);

        $_SESSION['orderItemList'] = $orderItemList;
        $_SESSION['orderToppingList'] = $orderToppingList;

        return redirect()->back()->with('status', 'カートから削除しました');
    }

    public function customedPriceCalc(int $price, int $index)
    {
        $orderItemList = $_SESSION['orderItemList'];
        foreach ($orderItemList as $key => $orderItem) {
            if ($orderItem->id == $index) {
                $orderItem->customed_price += $price;
            }
        }
        $_SESSION['orderItemList'] = $orderItemList;
        return;
    }

    public function updateQuantity(int $quantity, int $index)
    {
        $orderItemList = $_SESSION['orderItemList'];
        foreach ($orderItemList as $key => $orderItem) {
            if ($orderItem->id == $index) {
                $orderItem->quantity = $quantity;
            }
        }
        $_SESSION['orderItemList'] = $orderItemList;
        return;
    }

    public function removeDuplicateTopping(array $toppingIdList, array $orderToppingList)
    {
        $msg = '';
        foreach ($orderToppingList as $orderTopping) {
            foreach ($toppingIdList as $key => $toppingId) {
                if ($orderTopping->topping_id == $toppingId) {
                    $msg = '（重複するトッピングは除く）';
                    unset($toppingIdList[$key]);
                }
            }
        }
        $toppingIdList = array_values($toppingIdList);
        return array($msg, $toppingIdList);
    }


    public function updateTopping(array $toppingIdList, int $index, array $orderToppingList)
    {

        list($msg, $toppingIdList) = $this->removeDuplicateTopping($toppingIdList, $orderToppingList);

        $orderTopping = new OrderTopping();
        foreach ($toppingIdList as $toppingId) {
            $query = Topping::query();
            $orderTopping = $query->where('id', $toppingId)->first();
            $orderTopping->order_item_id = $index; //ここでorder_toppingsテーブルのorder_item_idを仮置きする。
            $orderTopping->topping_id = $query->where('id', $toppingId)->value('id');
            $this->customedPriceCalc($orderTopping->price, $index);
            $orderToppingList[] = $orderTopping;
        }
        $_SESSION['orderToppingList'] = $orderToppingList;
        return $msg;
    }

    public function addCartTopping(Request $request)
    {

        session_start();
        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
        } else {
            $orderToppingList = array();
        }

        //現在の数量を取得
        $orderItemList = $_SESSION['orderItemList'];
        foreach ($orderItemList as $index => $orderItem) {
            if ($orderItem->id == $request->index) {
                $currentQuantity = $orderItem->quantity;
            }
        }

        //toppingPriceの最後の数字だけを取得し、Toppingのidとして使用できるようにする。
        $toppingIdList = array();
        foreach ($request->request as $key => $value) {
            $result = strpos($key, 'toppingPrice');
            if ($result !== false) {
                $key = str_replace('toppingPrice', '', $key);
                $toppingIdList[] = $key;
            }
        }

        //quautityを利用するための処理
        foreach ($request->request as $key => $value) {
            $result = strpos($key, 'quantity');
            if ($result !== false) {
                $quantity = (int)$value;
            }
        }

        //変更内容がnullの場合の条件分岐
        if (count($toppingIdList) == 0 && $quantity == $currentQuantity) {
            return redirect()->back()->with(['status' => '更新内容を確認してください']);
        }
        if (count($toppingIdList) == 0 && $quantity != $currentQuantity) {
            $this->updateQuantity($quantity, $request->index);
            return redirect()->back()->with(['status' => '数量を変更しました']);
        }
        if (count($toppingIdList) != 0 && $quantity == $currentQuantity) {
            $msg = $this->updateTopping($toppingIdList, $request->index, $orderToppingList);
            return redirect()->back()->with(['status' => 'トッピングを変更しました' . $msg]);
        }

        $this->updateQuantity($quantity, $request->index);
        $msg = $this->updateTopping($toppingIdList, $request->index, $orderToppingList);

        # TODO トッピングの削除
        //

        return redirect()->back()->with(['status' => 'トッピングと数量を変更しました' . $msg]);
    }
}
