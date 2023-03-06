<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PrimaryCategory;
use App\Models\Item;
use App\Http\Requests\SellRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SellController extends Controller
{
    public function showSellForm(){
        $user = Auth::user();

   
        $categories = PrimaryCategory::orderBy('id')->get();
        return view('sell')->with('categories',$categories);
    }

    public function registerItem(SellRequest $request){
        $user = Auth::user();

        $item = new Item();
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->secondary_category_id = $request->input('category');
        $item->price = $request->input('price');
        $item->image_file = $request->input('image_file');

        $item->save();

        return redirect()->back()->with('status','商品を登録しました。');
    }
}
