<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function showItems(Request $request){
        $query = Item::query();
 
        // カテゴリで絞り込み
        if ($request->filled('category')) {
            list($categoryType, $categoryID) = explode(':', $request->input('category'));

            if ($categoryType === 'primary') {
                $query->whereHas('secondaryCategory', function ($query) use ($categoryID) {
                    $query->where('primary_category_id', $categoryID);
                });
            } else if ($categoryType === 'secondary') {
                $query->where('secondary_category_id', $categoryID);
            }
        }

        // キーワードで絞り込み
        if ($request->filled('keyword')) {
            $keyword = '%' . $this->escape($request->input('keyword')) . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', $keyword);
                $query->orWhere('description', 'LIKE', $keyword);
            });
        }
        

        $items = $query->orderBy('id', 'DESC')
           ->paginate(2);
        $user = Auth::user();
        return view('top')->with([
            'items' => $items,
            'user' => $user,
        ]
        );
    }

    public function showDetail(Item $item){
        return view('items.item_detail')->with('item',$item);
    }

    public function searchItems($keyword){
        $user = Auth::user();
        if(!$keyword){
            $items = Item::paginate(2);
        } else {
            $items = Item::where('name', 'like', '%'. $keyword .'%')->paginate(2);
        }
        return response()->json($items);
    }

    private function escape(string $value)
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $value
        );
    }
}
