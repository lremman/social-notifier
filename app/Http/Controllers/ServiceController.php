<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
	/**
	 *
	 */
    public function getCsrfToken()
    {
    	return response()->json([
    		'_token' => csrf_token(),
    	]);
    }
}
