<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemsController extends Controller
{
    public function showItems(){
        $items = Item::get();
        return view('top')->with('items',$items);
    }

    public function showDetail(Item $item){
        return view('items.item_detail')->with('item',$item);
    }
}
