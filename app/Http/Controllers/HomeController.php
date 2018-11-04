<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }

    public function verifyMail($email){
        Mail::send('mail', [], function ($message)
        {

            $message->from('me@gmail.com', 'Christian Nwamba');

            $message->to('mid90120@gmail.com');

        });
        return 'ss';
    }
}
