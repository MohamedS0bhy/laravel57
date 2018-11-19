<?php
namespace App\knet;
use Illuminate\Support\Facades\Log;
use App\Knet\e24PaymentPipe as KnetPayment;

/**
 * ApiKnet
 */
class ApiKnet 
{

	function __construct()
	{
		// parent::__construct();
		$this->knet_payment = new KnetPayment;
		$this->language = 'ARA';
		$this->amount = '1';
		$this->response_url = "knet/response";
		$this->error_url = "knet/error";
		$this->track_id = '';
		$this->udfs = [];
		$this->currency = 414;
		$this->action = 1;
		$this->debugEnabled = false;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function setResponseUrl($response_url)
	{
		$this->response_url = $response_url;
	}

	public function setErrorUrl($error_url)
	{
		$this->error_url = $error_url;
	}

	public function setTrackId($track_id)
	{
		$this->track_id = $track_id;
	}

	public function setUdfs($udfs)
	{
		$this->udfs = $udfs;
	}

	public function setCurrencey($currency)
	{
		$this->currency = $currency;
	}

	public function setAction($action)
	{
		$this->action = $action;
	}

	public function main_data()
	{
		$this->knet_payment->setAction(1);
		$this->knet_payment->setCurrency($this->currency);
		$this->knet_payment->setLanguage($this->language); //change it to "ARA" for arabic language
		$this->knet_payment->setResponseURL($this->response_url); // set your respone page URL
		$this->knet_payment->setErrorURL($this->error_url); //set your error page URL
		$this->knet_payment->setAmt($this->amount); //set the amount for the transaction
		//$this->knet_payment->setResourcePath("/Applications/MAMP/htdocs/php-toolkit/resource/");
		$this->knet_payment->setResourcePath(storage_path('knet/')); //change the path where your resource file is
		$this->knet_payment->setAlias(config('knet.alias', 'bnoon')); //set your alias name here
		$this->knet_payment->setTrackId(rand(1000,999));//generate the random number here
		for ($i=1; $i < count($this->udfs); $i++) {
			$this->knet_payment->{'setUdf' . $i}($this->udfs[$i]); //set User defined value
		}
	}

	public function performPayment()
	{
		$this->main_data();
		if($this->knet_payment->performPaymentInitialization()!=$this->knet_payment->SUCCESS){
				$this->debug([
					"Failure",
					"Result=".$this->knet_payment->SUCCESS,
					$this->knet_payment->getErrorMsg(),
					$this->knet_payment->getDebugMsg()
				]);
				return false;
		} else {
			$this->payment_id = $this->knet_payment->getPaymentId();
            $this->payment_url = $this->knet_payment->getPaymentPage();
            $this->full_payment_url = $this->payment_url . '?PaymentID=' . $this->payment_id;
			$this->debug([
				"Success",
				$this->knet_payment->getDebugMsg()
			]);
			return true;
		}
	}

	public function performResponse()
	{
		$data = request()->all();
		$this->sorted_data = [
			'paymentid' => request()->input('paymentid', ''),
			'result' => request()->input('result', ''),
			'postdate' => request()->input('postdate', ''),
			'tranid' => request()->input('tranid', ''),
			'auth' => request()->input('auth', ''),
			'ref' => request()->input('ref', ''),
			'trackid' => request()->input('trackid', ''),
			'udf1' => request()->input('udf1', ''),
			'udf2' => request()->input('udf2', ''),
			'udf3' => request()->input('udf3', ''),
			'udf4' => request()->input('udf4', ''),
			'udf5' => request()->input('udf5', ''),
		];
		// Log::info('sorted_data');
		// Log::info($this->sorted_data);
		$this->generateUrlParams();
		if ($this->sorted_data['result'] == 'CAPTURED') {
			return true;
		} else {
			return false;
		}
	}

	public function generateUrlParams()
	{
    	$this->result_params = '?paymentid=' . $this->sorted_data['paymentid'];
    	$this->result_params .= '&result=' . $this->sorted_data['result'];
    	$this->result_params .= '&postdate=' . $this->sorted_data['postdate'];
    	$this->result_params .= '&tranid=' . $this->sorted_data['tranid'];
    	$this->result_params .= '&auth=' . $this->sorted_data['auth'];
    	$this->result_params .= '&ref=' . $this->sorted_data['ref'];
    	$this->result_params .= '&trackid=' . $this->sorted_data['trackid'];
    	$this->result_params .= '&udf1=' . $this->sorted_data['udf1'];
    	$this->result_params .= '&udf2=' . $this->sorted_data['udf2'];
    	$this->result_params .= '&udf3=' . $this->sorted_data['udf3'];
    	$this->result_params .= '&udf4=' . $this->sorted_data['udf4'];
    	$this->result_params .= '&udf5=' . $this->sorted_data['udf5'];
	}


	public function debug($messages)
	{
		if ($this->debugEnabled) {
			foreach ($messages as $message) {
				Log::info('K-Net API Debug');
				Log::info($message);
			}
		}
	}


}
