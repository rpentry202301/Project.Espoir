<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $orderItems = DB::table('order_items')->get();
        $items = DB::table('items')->get();
        foreach ($orderItems as $orderItem) {
            foreach ($items as $item) {
                if ($orderItem->item_id == $item->id) {
                    $orderItem->name = $item->name;
                }
            }
        }

        $orderToppings = DB::table('order_toppings')->get();
        $toppings = DB::table('toppings')->get();
        foreach ($orderToppings as $orderTopping) {
            foreach ($toppings as $topping) {
                if ($orderTopping->topping_id == $topping->id) {
                    $orderTopping->name = $topping->name;
                }
            }
        }

        foreach ($orderItems as $orderItem) {
            foreach ($orderToppings as $orderTopping) {
                if ($orderItem->id == $orderTopping->order_item_id) {
                }
            }
        }

        // dd($orderItems);

        return view('purchase-history')->with(['orders' => $orders, 'orderItems' => $orderItems, 'orderToppings' => $orderToppings]);
    }
}
