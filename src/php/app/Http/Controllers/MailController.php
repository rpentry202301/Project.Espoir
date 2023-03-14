<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\TestMail;
use Carbon\Carbon;

class MailController extends Controller
{
    public function send($request){
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $price_include_tax = $request->price_include_tax;
        $order_date = Carbon::now();
        $delivery_destination_name = $request->delivery_destination_name;
        $zipcode = $request->zipcode;
        $address = $request->address;
        $telephone = $request->telephone;
        $payment_method = $request->payment_method;


        Mail::to($email)->send(new TestMail($name,$price_include_tax,$order_date,$zipcode,$address,$payment_method));

        return redirect()->route('top');
    }
}
