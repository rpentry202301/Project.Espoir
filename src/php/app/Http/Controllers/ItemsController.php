<?php

namespace App\Http\Controllers;

use App\Models\OrderItem as ModelsOrderItem;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function showItems()
    {
        $items = Item::get();
        $user = Auth::user();
        return view('top')->with(
            [
                'items' => $items,
                'user' => $user,
            ]
        );
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
