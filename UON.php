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
		* Функция, которая добавляет нового туриста
		* @param string $tourist данные нового туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function addTourist($tourist)
		{
			return parent::makeCURLRequest('user/create.json', true, $tourist);
		}

		/**
		* Функция, которая обновляет старого туриста
		* @param string $tourist данные старого туриста
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function updateTourist($tourist)
		{
			return parent::makeCURLRequest('user/update/' . $tourist['u_id'] . '.json', true, $tourist);
		}
		
		/**
		* Функция, которая возвращает список туристов
		* @param int $page номер страницы
		* @return array Написаный по требованию к переменным и классам № 1
		*/
		public function getTouristsList($page)
		{
			return parent::makeCURLRequest('users/'. $page.'.json');
		}
	}