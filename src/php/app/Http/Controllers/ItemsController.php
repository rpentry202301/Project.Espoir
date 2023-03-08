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
        
        
        $items = $query->orderBy('secondary_category_id', 'ASC')
        ->simplePaginate(8)
        ->withQueryString();
        
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
        $user = Auth::user();
        return view('items.item_detail')->with(
            [
                'item' => $item,
                'user' => $user,
            ]
        );
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

