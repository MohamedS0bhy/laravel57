<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;

class WebPaymentController extends Controller
{
    public function confirm(){
    	$this->payment = new PaymentController();
    	dd($this->payment->confirm());
    }
}
