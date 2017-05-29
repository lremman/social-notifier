<?php

namespace App\Ext\SMS\Vendor;

use BFunky\HttpParser\HttpParser;
use App\Ext\SMS\Vendor\SendingSMSException;
use Guzzle\Http\Client;

abstract class AbstractSMS {


	/**
	 * @var string
	 */
	private $login;

	private $password;

	protected $from;

	protected $number;

	protected $message;

	protected $response = [];

	public $baseUrl = 'http://sms-fly.com/api/api.noai.php';

	/**
	 * 
	 */
	public function __construct()
	{
		$this->setAuthData();
	}

	protected function setAuthData()
	{
		$this->login = config('services.smsfly.login');
		$this->password = config('services.smsfly.password');
	}

	/**
	 * 
	 */
	private function sendData($dataXml)
	{
		$client = new Client();

		$request = $client->post(
			$this->baseUrl,
			[
				'Content-Type' => 'text/xml',
			],
			$dataXml
		);
		$request->setAuth($this->login, $this->password);

		$response = $request->send();

		$this->response = [
			'success' => $response->getStatusCode() == 200 ? true : false,
		];

		return $this;
	}

	/**
	 * 
	 */
	public function send()
	{
		$data = $this->makeXml([
			'msg' => $this->message,
			'from' => $this->from,
			'to' => $this->number,
		]);

		$response = $this->sendData($data);

		return $this;
	}

	/**
	 * 
	 */
	public function makeXml($data)
	{
		$xml = 
			'<?xml version="1.0" encoding="utf-8"?>' .
			'<request>' .
			   '<operation>SENDSMS</operation>' .
			   '<message start_time="AUTO" end_time="AUTO" lifetime="4" desc="SocialNotifier registration" source="' . array_get($data, 'from') . '">' .
			      '<recipient>' . array_get($data, 'to') . '</recipient>' .	
			      '<body>' . array_get($data, 'msg') . '</body>' .
			   '</message>' .
			'</request>'
		;
		return $xml;
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
		return $this;
	}

	/**
	 * 
	 */
	public function setNumber(int $number)
	{
		$this->number = $number;
		return $this;
	}

	/**
	 * 
	 */
	public function setMessage(string $message)
	{
		$this->message = $message;
		return $this;
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

	}