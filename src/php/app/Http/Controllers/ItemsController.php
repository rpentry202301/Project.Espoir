<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function showDetail(Item $item)
    {
        return view('items.item_detail')->with('item', $item);
    }
}
