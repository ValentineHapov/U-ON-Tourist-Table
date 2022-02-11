<?php 
	/**
	* Post-файл, для создания и редактирования туристов
	*
	* Используется исключително для того,
	* чтобы понять, нужно ли редактировать
	* или создавать нового туриста, отправить
	* по нужной ветке информацию на сервер, 
	* получить со стороны сервера ответ и
	* вернуть его пользователю
	* их клиенту
	* @author ValentineHapov <haps-jr@list.ru>
	* @version 0.4
	* @package files
	*/

	/**
	* Подключение написанного мной "API"
	*/
	include("UON.php");
	
	/**
	* Создание объекта для подключения
	*/
	$uon = new UON();

	/**
	* Решаем, что мы делаем:
	* - Обновляем старого туриста
	* - Создаем нового туриста
	*/
	if(isset($_POST['u_id']))
	{
		/*
		* Редактируем старого туриста.
		* Возвращаем ответ так, как есть.
		* Это поможет нам на самой странице вызывать предупреждение об ошибках.
		*/
		print_r(json_encode($uon->updateTourist($_POST)));
	}
	else
	{
		/*
		* Создаем нового туриста.
		* Возвращаем ответ так, как есть.
		* Это поможет нам на самой странице вызывать предупреждение об ошибках.
		*/
		print_r(json_encode($uon->addTourist($_POST)));
	}