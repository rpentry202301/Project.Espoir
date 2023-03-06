<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrimaryCategory;

class SellController extends Controller
{
    public function showSellForm(){
        $categories = PrimaryCategory::orderBy('id')->get();
        return view('sell')->with('categories',$categories);
    }
}
