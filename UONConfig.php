<?php
	/**
	* Файл класса UONСonfig, для хранения настроечной информации
	*
	* Хранит в себе ключ и время последнего подключения
	* @author ValentineHapov <haps-jr@list.ru>
	* @version 0.4
	* @package files
	*/

	/*
	* Класс хранения настроек
	* Написан по требованию к переменным и классам №2
	* @package files
	* @subpackage classes
	*/
	class UONConfig {
		/**
		* АPI-ключ пользователя
		* Добавлен по требованию к переменным и классам №2
		*/
		const APIKey = "yUM50Pq2sLs2cY5R6jz71644506654";
		
		/**
		* Последнее время подключения
		* Используется для создания интервалов между запросами
		*/
		static protected $lastConnect;
		
		/**
		* Установка стартового значения для lastConnect
		* @return void
		*/
		public function __construct()
		{
			$lastConnect = time();
		}
		
		/**
		* Функция, нужная исключительно для защиты от попытки редактирования APIKey
		* @return string API ключ
		*/
		protected function getAPIKey()
		{
			return self::APIKey;
		}
		
		/**
		* Функция, собранная из 3х тривиальных. Исходя из того, как работает
		* API такого функционала пока что будет достаточно
		* @param string $urlTale Все ссылки на Post-/Get-запросы реализованы практически одинаково. Это та часть ссылки, которая изменяется
		* @param bool $isPostMethod Уточнение метода отправки. true = POST, false = GET.
		* @param bool $postFields В случае, если это POST запрос, определяет для него структуру, которая передастся вместе с запросом
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		protected function makeCURLRequest($urlTale, $isPostMethod = false, $postFields = null)
		{
			$curTime = time();
			
			$url = 'https://api.u-on.ru/'. self::getAPIKey() . '/' .$urlTale;
			
			$curlParams =  array(
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_URL => $url,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_SSL_VERIFYPEER => false
				);
			
			$curl = curl_init();
			if ($isPostMethod) {
				$curlParams[CURLOPT_POST] = true;
				$curlParams[CURLOPT_POSTFIELDS] = $postFields;
				curl_setopt_array($curl, $curlParams);
			}
			else
			{
				$curlParams[CURLOPT_POST] = false;
				curl_setopt_array($curl,$curlParams);
			}
			usleep(100000);
			
			$returnData = array (
				"status" => "error",
				"result" => array(),
				"errInfo" => "",
				"errors" => array(),
			);
			
			if(($resp = curl_exec($curl)) === false)
			{
				$curlError = curl_error($curl);
				$returnData["errInfo"] = "Ошибка curl: " . $curlError;
				$returnData["errors"] = array($curlError);
				return $returnData;	
			}
			else if (isset(($outJSON = json_decode($resp))->result) && ($outJSON->result!=200))
			{
				$returnData["result"] = $outJSON->result;
				$returnData["errInfo"] = $outJSON->message;
				$returnData["errors"] = array($outJSON->message);
				return $returnData;	
			}
			else if (isset($outJSON->error))
			{
				$returnData["result"] = $outJSON->result;
				$returnData["errInfo"] = $outJSON->message;
				$returnData["errors"] = array($outJSON->message);
				return $returnData;	
			}
			unset($outJSON->result);
			$returnData = array (
				"status" => "success",
				"result" => $outJSON,
				"errInfo" => "",
				"errors" => array(),
			);

			curl_close($curl);
			return $returnData;
		}
	}