<?php

include_once("UONConfig.php");

Class UON extends UONConfig {
	
	private function makeCURLRequest($urlTale, $isPostMethod = false, $postFields = null)
	{
		$curTime = time();
		if ($curTime == parent::$lastConnect)
			sleep(1);
		$url = 'https://api.u-on.ru/'. self::getAPIKey() . '/' .$urlTale;
		$curl = curl_init();
		if ($isPostMethod) {
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL =>$url,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postFields,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false
			));
		}
		else
		{
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL =>$url,
				CURLOPT_POST => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false
			));
		}
		
		if(($resp = curl_exec($curl)) === false)
		{
			$curlError = curl_error($curl);
			$returnData = array (
				"status" => "error",
				"result" => array(),
				"errInfo" => "Ошибка curl: " . $curlError,
				"errors" => array($curlError),
			);
		}
		else if (isset(($outJSON = json_decode($resp))->result) && ($outJSON->result!=200))
		{
			$returnData = array (
				"status" => "error",
				"result" => $outJSON->result,
				"errInfo" => $outJSON->message,
				"errors" => array($outJSON->message),
			);
		}
		else if (isset($outJSON->error))
		{
			$returnData = array (
				"status" => "error",
				"result" => $outJSON->error->code,
				"errInfo" => $outJSON->error->message,
				"errors" => array($outJSON->error->message),
			);
		}
		else
		{
			unset($outJSON->result);
			$returnData = array (
				"status" => "success",
				"result" => $outJSON,
				"errInfo" => "",
				"errors" => array(),
			);
		}
		curl_close($curl);
		return $returnData;
	}
	
	public function addTourist($tourist)
	{
		return self::makeCURLRequest('user/create.json', true, $tourist);
	}
	
	public function updateTourist($tourist)
	{
		return self::makeCURLRequest('user/update/' . $tourist['u_id'] . '.json', true, $tourist);
	}
	
	public function getTouristsList($page)
	{
		return self::makeCURLRequest('users/'. $page.'.json');
	}
}