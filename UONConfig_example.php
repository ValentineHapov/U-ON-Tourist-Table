<?php
	/**
	* Файл класса UONexample, для взаимодействия с API
	*
	* Показывает, как это дожно работать, на примере примеров руководства из API
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
	Class UONexample extends UONConfig {
		/**
		* Пример создания заявки на языке программирования РНР
		* @param string $tourist данные нового туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function createRequestOnPHP($req)
		{
			return parent::makeCURLRequest('lead/create.json', true, $req);
		}

		/**
		* Пример получения списка стран
		* @param string $tourist данные старого туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function getListOfCountries()
		{
			return parent::makeCURLRequest('countries.json');
		}
		
		/**
		* Пример отправки списка услуг при создании заявки
		* @param array $query структура запроса
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function addServicesWithRequest($query)
		{
			return @parent::makeCURLRequest('request/create.json',true, $query);
		}
	}
	
	$uox = new UONexample();
	
	/*
	* Пример я решил сделать через Get-запрос, чтобы протестировать сразу в браузере
	*/
	if (isset($_GET['type']))
	{
		if (isset($_GET['u_name'])&&isset($_GET['u_phone']))
		$req = array(
			"source" => "заявка с сайта",
			"u_name" => $_GET['u_name'],
			"u_phone" => $_GET['u_phone']
		);
		switch($_GET['type'])
		{
			case 0:
				print_r($uox->addServicesWithRequest(array(
                        'note' => 'заявка с сайта',
                        'services' => array(
                            array(
                                'type_id' => 1,
                                'country' => 'Испания',
                            ),
                            array(
                                'type_id' => 2,
                                'country' => 'Испания',
                            )
                        )
                    ))
                );
				break;
			case 1:
				print_r($uox->getListOfCountries());
				break;
			case 2:
				print_r($uox->createRequestOnPHP($req));
				break;
		}
		
	}