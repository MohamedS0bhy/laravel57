<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Mail::send('emails.user_payment_info', $data, function($message) use ($data)
        {
            $message
                ->to(Auth::user()->email, $data['settings']['siteName'.ucfirst(LANG_SHORT)])
                ->subject(trans('main.Your Knet Payment Info'));
        });
        return view('home');
    }
}
