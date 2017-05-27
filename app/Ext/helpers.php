<?php

function ajaxResponse($data, $code = null)
{

	if(!is_array($data)) {
		$data = json_decode(json_encode($data), true);
	}

	$data = array_merge($data, [
		'token' => csrf_token()
	]);

	if ($code) {
		return response()->json($data, $code);
	}

	return response()->json($data);

}