<?php
	/**
	* Файл класса UON, для взаимодействия с API
	*
	* Позволяет по вызову одной функции без
	* нагромождений получить список туристов,
	* отредактировать их и создавать новых
	* @author ValentineHapov <haps-jr@list.ru>
	* @version 0.4
	* @package files
	*/
	
	/**
	* Подключение объекта Config'a по требованию к переменным и классам №2 Руководства по написанию кода
	*/
	include_once("UONConfig.php");

	/**
	* Класс упрощенного взаимодействия с API
	* @package files
	* @subpackage classes
	*/
	Class UON extends UONConfig {
		/**
		* Функция, собранная из 3х тривиальных. Исходя из того, как работает
		* API такого функционала пока что будет достаточно
		* @param string $urlTale Все ссылки на Post-/Get-запросы реализованы практически одинаково. Это та часть ссылки, которая изменяется
		* @param bool $isPostMethod Уточнение метода отправки. true = POST, false = GET.
		* @param bool $postFields В случае, если это POST запрос, определяет для него структуру, которая передастся вместе с запросом
		* @return array Написаный по требованию к переменным и классам № 1
		*/
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

		/**
		* Функция, которая добавляет нового туриста
		* @param string $tourist данные нового туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function addTourist($tourist)
		{
			return self::makeCURLRequest('user/create.json', true, $tourist);
		}

		/**
		* Функция, которая обновляет старого туриста
		* @param string $tourist данные старого туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function updateTourist($tourist)
		{
			return self::makeCURLRequest('user/update/' . $tourist['u_id'] . '.json', true, $tourist);
		}
		
		/**
		* Функция, которая возвращает список туристов
		* @param int $page номер страницы
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function getTouristsList($page)
		{
			return self::makeCURLRequest('users/'. $page.'.json');
		}
	}