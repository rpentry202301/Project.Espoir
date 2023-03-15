<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\TestMail;
use Carbon\Carbon;

class MailController extends Controller
{
    public function send($request, $deliveryDestination){
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $price_include_tax = $request->price_include_tax;
        $order_date = Carbon::now();
        $delivery_destination_name = $deliveryDestination->delivery_destination_name;
        $zipcode = $deliveryDestination->zipcode;
        $address = $deliveryDestination->address;
        $telephone = $deliveryDestination->telephone;
        $payment_method = '';
        if($request->payment_method == 1){
            $payment_method = '代金引換';
        }else if($request->payment_method == 2){
            $payment_method = 'クレジットカード';
        }


        Mail::to($email)->send(new TestMail($name,$price_include_tax,$order_date,$zipcode,$address,$payment_method));

        return redirect()->route('top');
    }
}
