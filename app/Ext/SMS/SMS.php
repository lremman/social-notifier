<?php

namespace App\Ext\SMS;

use App\Ext\SMS\Vendor\AbstractSMS;

final class SMS extends AbstractSMS {

	/**
	 * 
	 */
	public function formatPhone($phone)
	{
		$prettified = phone($phone, 'UA', \libphonenumber\PhoneNumberFormat::NATIONAL);
		$withoutSpaces = str_replace(' ', '', $prettified);
		return '38' . $withoutSpaces;
	}


}