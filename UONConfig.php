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
}