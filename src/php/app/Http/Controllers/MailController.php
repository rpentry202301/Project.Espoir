<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function send(){
        $name = '伊藤';
        $email = 'kazuki.ito@rakus-partners.co.jp';

        Mail::to($email)->send(new TestMail($name));

        return redirect()->route('top');
    }
}
