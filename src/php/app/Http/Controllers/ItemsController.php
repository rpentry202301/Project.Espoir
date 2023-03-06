<?php

namespace App\Http\Controllers;

use App\Models\OrderItem as ModelsOrderItem;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;

class ItemsController extends Controller
{
    public function showItems()
    {
        $items = Item::get();
        return view('top')->with('items', $items);
    }

    public function showDetail(Item $item)
    {
        return view('items.item_detail')->with('item', $item);
    }

    public function showCartItem()
    {
        // 既にカートに商品が存在しているかどうか判別。一旦SESSIONは考えずに作成する。
        session_start();
        if (isset($_SESSION['orderItemList'])) {
            var_dump('not else');
            $orderItemList = $_SESSION['orderItemList'];
        } else {
            var_dump('else');
            $orderItemList = array();
        }

        // //一旦、カートに商品ID:1が入るように設定
        // $query = Item::query();
        // $orderItems = new OrderItem(); //Itemを継承したOrderItemはプロパティにItemのプロパティを持つ。
        // $orderItems = $query->where('id', 1)->get();
        // $orderItemList[] = $orderItems;

        return view('items.show_cart', ['orderItemList' => $orderItemList]);
    }

    public function addCartItem(Request $request)
    {
        // 既にカートに商品が存在しているかどうか判別。一旦SESSIONは考えずに作成する。
        session_start();
        if (isset($_SESSION['orderItemList'])) {
            var_dump('not else');
            $orderItemList = $_SESSION['orderItemList'];
        } else {
            var_dump('else');
            $orderItemList = array();
        }

        //一旦idの1が入るように設定
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
}
