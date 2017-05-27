<?php

namespace App\Ext\SMS\Vendor;

use BFunky\HttpParser\HttpParser;
use App\Ext\SMS\Vendor\SendingSMSException;

abstract class AbstractSMS {


	/**
	 * @var string
	 */
	private $username;

	private $userid;

	private $handle;

	protected $from;

	protected $number;

	protected $message;

	protected $response = [];

	public $baseUrl = 'https://api.budgetsms.net/sendsms';

	/**
	 * 
	 */
	public function __construct()
	{
		$this->setAuthData();
	}

	protected function setAuthData()
	{
		$this->username = config('services.budgetSMS.username');
		$this->userid = config('services.budgetSMS.user_id');
		$this->handle = config('services.budgetSMS.handle');

	}

	/**
	 * 
	 */
	private function sendData($data)
	{
		$url = $this->baseUrl . '?' . http_build_query($data);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPGET, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		$result = curl_exec($curl);

		curl_close($curl);

		$this->response = $this->parseResponse($result);


		return $this;
	}

	/**
	 * 
	 */
	public function parseResponse(string $response)
	{
		if ( preg_match('/ERR (\w+)/', $response, $m) ) {
   			$this->returnException(array_get($m, 1));
		} elseif ( preg_match('/OK (\w+)/', $response, $m) ) {
			return [
				'success' => true,
				'message' => 'success',
				'code' => $m[1],
			];
		}
	}

	/**
	 * 
	 */
	public function send()
	{
		$response = $this->sendData([
			'username' => $this->username,
			'userid' => $this->userid,
			'handle' => $this->handle,
			'msg' => $this->message,
			'from' => $this->from,
			'to' => $this->number,
		]);

		return $this;
	}

	/**
	 * 
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * 
	 */
	public function setData(string $from, int $number, string $message)
	{
		$this->setFrom($from);
		$this->setNumber($number);
		$this->setMessage($message);

		return $this;
	}

	/**
	 * 
	 */
	public function setFrom(string $from)
	{
		$this->from = $from;
	}

	/**
	 * 
	 */
	public function setNumber(int $number)
	{
		$this->number = $number;
	}

	/**
	 * 
	 */
	public function setMessage(string $message)
	{
		$this->message = $message;
	}

	/**
	 * 
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * 
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * 
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * 
	 */
	protected function returnException($code) 
	{
		$errors = [
			'1001'	=> 'Not enough credits to send messages',
			'1002'	=> 'Identification failed. Wrong credentials',
			'1003'	=> 'Account not active, contact BudgetSMS',
			'1004'	=> 'This IP address is not added to this account. No access to the API',
			'1005'	=> 'No handle provided',
			'1006'	=> 'No UserID provided',
			'1007'	=> 'No Username provided',
			'2001'	=> 'SMS message text is empty',
			'2002'	=> 'SMS numeric senderid can be max. 16 numbers',
			'2003'	=> 'SMS alphanumeric sender can be max. 12 characters',
			'2004'	=> 'SMS senderid is empty or invalid',
			'2005'	=> 'Destination number is too short',
			'2006'	=> 'Destination is not numeric',
			'2007'	=> 'Destination is empty',
			'2008'	=> 'SMS text is not OK (check encoding?)',
			'2009'	=> 'Parameter issue (check all mandatory parameters, encoding, etc.)',
			'2010'	=> 'Destination number is invalidly formatted',
			'2011'	=> 'Destination is invalid',
			'2012'	=> 'SMS message text is too long',
			'2013'	=> 'SMS message is invalid',
			'2014'	=> 'SMS CustomID is used before',
			'2015'	=> 'Charset problem',
			'2016'	=> 'Invalid UTF-8 encoding',
			'2017'	=> 'Invalid SMSid',
			'3001'	=> 'No route to destination. Contact BudgetSMS for possible solutions',
			'3002'	=> 'No routes are setup. Contact BudgetSMS for a route setup',
			'3003'	=> 'Invalid destination. Check international mobile number formatting',
			'4001'	=> 'System error, related to customID',
			'4002'	=> 'System error, temporary issue. Try resubmitting in 2 to 3 minutes',
			'4003'	=> 'System error, temporary issue.',
			'4004'	=> 'System error, temporary issue. Contact BudgetSMS',
			'4005'	=> 'System error, permanent',
			'4006'	=> 'Gateway not reachable',
			'4007'	=> 'System error, contact BudgetSMS',
			'5001'	=> 'Send error, Contact BudgetSMS with the send details',
			'5002'	=> 'Wrong SMS type',
			'5003'	=> 'Wrong operator',
			'6001'	=> 'Unknown error',
			'7001'	=> 'No HLR provider present, Contact BudgetSMS.',
			'7002'	=> 'Unexpected results from HLR provider',
			'7003'	=> 'Bad number format',
			'7901'	=> 'Unexpected error. Contact BudgetSMS',
			'7902'	=> 'HLR provider error. Contact BudgetSMS',
			'7903'	=> 'HLR provider error. Contact BudgetSMS',
		];

		if($errorText = array_get($errors, $code)) {
			throw new SendingSMSException($errorText);
		}

		throw new SendingSMSException('BudgetSMS API error');
	}

}