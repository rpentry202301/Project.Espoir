<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\PrimaryCategory;
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

    public function showEditForm(Item $item){
        $categories = PrimaryCategory::orderBy('id')->get();
        $user = Auth::user();
        return view('items.edit_form')->with([
            'categories'=>$categories,
            'user'=>$user,
            'item'=>$item
        ]);
    }

    public function stopSelling(Item $item){
        if($item->is_selling == 1){
            $item->is_selling = 0;
            $item->save();
            return redirect()->back()->with('status','商品を販売休止にしました。');
        }else{
            return redirect()->back()->with('status','販売状況の変更に失敗しました。');
        }
    }
    
    public function restartSelling(Item $item){
        if($item->is_selling == false){
            $item->is_selling = 1;
            $item->save();
            return redirect()->back()->with('status','商品を販売中にしました。');
        }else {
            return redirect()->back()->with('status','販売状況の変更に失敗しました。');
        }
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

