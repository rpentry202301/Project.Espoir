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
        $imageName = $this->saveImage($request->file('item-image'));
        
        $item = new Item();
        $item->image_file = $imageName;
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->secondary_category_id = $request->input('category');
        $item->price = $request->input('price');

        $item->save();

        return redirect()->back()->with('status','商品を登録しました。');
    }

    /**
     * 商品画像をリサイズして保存する
     * 
     * @param UploadedFile $file アップロードされた商品画像
     * @return string ファイル名
     */
    private function saveImage(UploadedFile $file):string {
        $tempPath = $this->makeTempPath();
        Image::make($file)->fit(300,300)->save($tempPath);
        $filePath = Storage::disk('public')->putFile('item-images',new File($tempPath));

        return basename($filePath);
    }

    /**
     * 一時的なファイルを生成してパスを返す
     * 
     * @return string ファイルパス
     */
    private function makeTempPath():string {
        $tmp_fp = tmpfile();
        $meta = stream_get_meta_data($tmp_fp);

        return $meta["uri"];
    }
}
