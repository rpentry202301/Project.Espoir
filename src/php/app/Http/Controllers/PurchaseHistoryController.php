<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    //
    public function showPurchaseHistory()
    {
        return view('purchase-history');
    }
}
