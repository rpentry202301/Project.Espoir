<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function showItems(){
        return view('top');
    }
}
