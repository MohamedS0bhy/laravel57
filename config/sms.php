<?php

return [
	'sms_username'		=> env('SMS_USERNAME' , 'Magic'),
    'sms_password'		=> env('SMS_PASSWORD' , '4112010'),
    'sms_api_id'		=> env('SMS_API_ID' , '925'),
    'sms_sender_text'	=> env('SMS_SENDER_TEXT' , 'SMSBOX.COM'),
    'sms_url'			=> env('SMS_URL' , 'http://173.230.227.174/SMSGateway/Services/Messaging.asmx/Http_SendSMS'),
    'sms_status_url'	=> env('SMS_STATUS_URL' , 'http://173.230.227.174/SMSGateway/Services/Messaging.asmx/Http_GetSmsStatus'),
	];