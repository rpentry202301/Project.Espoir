<?php

namespace App\Http\Controllers;

use App\Models\OrderItem as ModelsOrderItem;
use Illuminate\Http\Request;
use src\php\app\Models\OrderItem;
use src\php\app\Models\Item;

class ItemsController extends Controller
{
    public function showItems()
    {
        return view('top');
    }

    public function showCartItem()
    {
        //一旦、カートに商品ID:1が入るように設定
        $query = Item::query();
        // $orderItem = new OrderItem();
        $orderItem = $query->where('id', 1)->get();

        // //既にカートに商品が存在しているかどうか判別
        // session_start();
        // if (isset($_POST['orderItems'])) {
        //     $orderItems = $_POST['orderItems'];
        // } else {
        //     $orderItems = [];
        // }

        return view('items.show_cart', ['orderItem' => $orderItem]);
    }

    public function addCartItem(Request $request)
    {
        //既にカートに商品が存在しているかどうか判別
        session_start();
        if (isset($_POST['orderItems'])) {
            $orderItems = $_POST['orderItems'];
        } else {
            $orderItems = [];
        }

        //一旦idの1が入るように設定
        $request->id = 1;

        //カートに追加する商品を追加する
        $query = Item::query();
        $orderItem = new OrderItem();
        $orderItem = $query->where('id', $request->id)->get();

        $orderItems[] = $orderItem;
        $_SESSION['orderItems'] = $orderItems;

        //直前の画面に戻る
        return redirect()->back();
    }

    public function deleteCartItem(Request $request)
    {
        $orderItems = '';
        return redirect()->back();
    }
}
