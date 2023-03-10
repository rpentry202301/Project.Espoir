<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PurchaseHistoryController extends Controller
{
    //
    public function showPurchaseHistory()
    {
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            if ($order->payment_method == 1) {
                $order->payment_method = '代金引換';
            } else if ($order->payment_method == 2) {
                $order->payment_method = 'クレジットカード';
            }
        }

        $users = DB::table('users')->get();
        foreach ($orders as $order) {
            foreach ($users as $user) {
                if ($user->id == $order->user_id) {
                    $order->user_id = $user->name;
                }
            }
        }
        return view('purchase-history')->with(['orders' => $orders]);
    }
}
