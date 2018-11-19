<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\knet\ApiKnet;

class PaymentController extends Controller
{
	function __construct(){
		$this->knet_api = new ApiKnet;
	}
    public function confirm(){
    	// dd(config('knet.alias', 'bnoon'));
    	$this->knet_api = new ApiKnet;
    	$this->knet_api->setResponseUrl(url('api/payments/knet-response/5'));
		$this->knet_api->setErrorUrl(url('api/payments/knet-response/5'));

		$result = $this->knet_api->performPayment();
		if ($result)
			return redirect($this->knet_api->full_payment_url);
		return response([
                'message' => 'confirm fail return ' ,
            ] , 422);
    }

	public function knetResponse($paymentID,$others = false)
	{
		
		$result = $this->knet_api->performResponse();
        
		$payment_error_url = url('api/payments/error/' . $paymentID);
		$payment_success_url = url('api/payments/success/' . $paymentID);

		$this->knet_api->sorted_data['paymentID'] = $this->knet_api->sorted_data['paymentid'];

		if ($result) {
			// $user = User::find(Auth::id());

			// if(!$user)
			// 	return Redirect::to(url(''))
			// 			->withError([trans('home.USER_NOT_FOUND')]);

			// $user->credits += $this->knet_api->amount;
			// $user->save();

			return redirect(url($payment_success_url . $this->knet_api->result_params));
		}
		else
			return redirect(url($payment_error_url . $this->knet_api->result_params));

	}

	public function success()
	{
		return response([
                'message' => request()->all() ,
            ] , 200);
		if(!Request::segment(3))
			return Redirect::to(url(''));

		$data['settings'] = $this->_setting;
		$data['user'] = User::find(Auth::id());
		$data['amount'] = $this->knet_api->amount;
		Mail::send('emails.user_payment_info', $data, function($message) use ($data)
		{
			$message
				->to(Auth::user()->email, $data['settings']['siteName'.ucfirst(LANG_SHORT)])
				->subject(trans('main.Your Knet Payment Info'));
		});

		// Mail::send('emails.admin_user_payment_success', $data, function($message) use ($data)
		// {
		// 	$message
		// 		->to($data['settings']['adminEmail'], $data['settings']['siteNameEn'])
		// 		->subject(trans('main.New Payment For Registered') . ' #' . $data['ad']->id);
		// });

		return View::make('payments.success')
					->with('amount',$this->knet_api->amount)
					->with('title',trans('main.Payment Successfully'));
	}

	public function error()
	{
return response([
                'message' => request()->all() ,
            ] , 200);
		if(!Request::segment(3)) {
			return Redirect::to(url(''));
		}

		$data['settings'] = $this->_setting;
		$data['user'] = User::find(Auth::id());
		$data['amount'] = $this->knet_api->amount;
		Mail::send('emails.user_payment_info', $data, function($message) use ($data)
		{
			$message
				->to(Auth::user()->email, $data['settings']['siteName'.ucfirst(LANG_SHORT)])
				->subject(trans('main.Your Knet Payment Info'));
		});
		// Mail::send('emails.user_payment_failed', $data, function($message) use ($data)
		// {
		// 	$message
		// 		->to(Auth::user()->email, $data['settings']['siteName'.ucfirst(LANG_SHORT)])
		// 		->subject(trans('main.Payment Failed - Try Again Later'));
		// });

		return View::make('payments.error')
					->with('amount',$this->knet_api->amount)
					->with('title',trans('main.Payment Failed'));
	}
}
