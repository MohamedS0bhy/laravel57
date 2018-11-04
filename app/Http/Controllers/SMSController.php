<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    private $sms_username 		= 'Magic';
    private $sms_password 		= '4112010';
    private $sms_api_id   		= '925';
    private $sms_sender_text   	= 'SMSBOX.COM';
    private $sms_url      		= 'http://173.230.227.174/SMSGateway/Services/Messaging.asmx/Http_SendSMS';
    private $sms_status_url 	= 'http://173.230.227.174/SMSGateway/Services/Messaging.asmx/Http_GetSmsStatus';


    public function send_sms( $phone, $text ){
        $url = $this->sms_url . '?username=' . urlencode($this->sms_username) .
        '&password=' . urlencode($this->sms_password) .
        '&customerId=' . $this->sms_api_id .
        '&senderText=' . $this->sms_sender_text .
        '&defDate=' .
        '&isBlink=false' .
        '&isFlash=false' .
        '&recipientNumbers=' . $phone .
        '&messageBody=' . urlencode( $text );
         
         Log::info($url);
         // Log::info('send_sms 1');
        $content = $this->fetchUrl( $url );
        // Log::info('send_sms 2');
        // Log::info($content);
        $content = $this->xml($content);
        // Log::info($content);
        return ($content['Result'] == 'true') ? $content['messageId'] : false;
    }

	function fetchUrl($url) {
	    $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
	    if (!$allowUrlFopen) {
	        Log::info('[$url 1]', [$url]);
	        $context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	        return file_get_contents($url,false,$context);
	    } elseif (function_exists('curl_init')) {
	        Log::info('[$url 2]', [$url]);
	        
	        $c = curl_init();
	        curl_setopt($c, CURLOPT_URL, $url);
	        curl_setopt($c, CURLOPT_ENCODING , "gzip"); 
	        curl_setopt($c, CURLOPT_ENCODING, '');
	        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($c, CURLOPT_TIMEOUT, 30);
	        curl_setopt($c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
	        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	        Log::info('[Started]');
	        $contents = curl_exec($c);
	        Log::info('curl status', curl_getinfo($c));
	        Log::info('curl Error:' . curl_error($c));
	        
	        curl_close($c);
	        Log::info('[finished] ' . $contents);
	        if (is_string($contents)) {
	            return $contents;
	        }
	    }
	    return false;
	}

    public function get_sms_status($id){
        // http://sms.wavaisms.com/smsgateway/services/messaging.asmx/Http_GetSmsStatus?username=Meshnskw&password=Mes123%21%40%23&customerId=306&messageId=946e9628-c7ef-4ce9-b2e1-c7560856ed77&detailed=true
        $url = $this->sms_status_url . '?username=' . urlencode($this->sms_username) .
        '&password=' . urlencode($this->sms_password) .
        '&customerId=' . $this->sms_api_id .
        '&messageId=' . $id .
        '&detailed=true';
        $content = @file_get_contents( $url );
        $content = $this->xml($content);
        return ($content['Counters']['SentCount'] == '1') ? true : false;
    }

    public function xml($string) {
        if ($string) {
            $xml = @simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
            if(!$xml)
                throw new ParserException('Failed To Parse XML');
            return json_decode(json_encode((array) $xml), 1);   // Work arround to accept xml input
        }
        return array();
    }

}
