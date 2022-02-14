<?php
/**
* Index-файл проекта
*
* Из-за того, что index-файл получился слишком статичным
* я решил его сделать обычным HTML файлом, который содержит
* Шаблон для таблицы, код JavaScript, и форму, которая всплывает
* при потребности в редактировании и создании
* @author ValentineHapov <haps-jr@list.ru>
* @version 0.4
* @package files
*/
?>
<html>
<head>
<title>
TEST
</title>                                                           
<script type="text/javascript" src="jquery.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="TouristAPI.js"></script>
</head>
<body>
<h1>Таблица со списком туристов</h1><br>
<table class="mainTable">
	<tr>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>Дата рождения</th>
		<th>Фамилия в загранпаспорте</th>
		<th>Имя в загранпаспорте</th>
		<th>Дата истечения годности загранпаспорта</th>
		<th>Примечание</th>
	</tr>
</table>
<div class="shading">
	<div class="form-popup" id="myForm">
	  <form action="/addTourist.php" class="form-container">
		<h1>Турист</h1>

		<label for="u_surname"><b>Фамилия</b></label>
		<input type="text" placeholder="Введите Фамилию" name="u_surname" required>

		<label for="u_name"><b>Имя</b></label>
		<input type="text" placeholder="Введите Имя" name="u_name" required>

		<label for="u_sname"><b>Отчество</b></label>
		<input type="text" placeholder="Введите Отчество" name="u_sname" required>

		<label for="u_birthday"><b>Дата рождения</b></label>
		<input type="text" placeholder="Введите Дату рождения" name="u_birthday" required>

		<label for="u_surname_en"><b>Фамилия в загранпаспорте</b></label>
		<input type="text" placeholder="Введите Фамилию в загранпаспорте" name="u_surname_en" required>

		<label for="u_name_en"><b>Имя в загранпаспорте</b></label>
		<input type="text" placeholder="Введите Имя в загранпаспорте" name="u_name_en" required>

		<label for="u_zagran_expire"><b>Дата истечения годности загранпаспорта</b></label>
		<input type="text" placeholder="Введите Дату истечения годности загранпаспорта" name="u_zagran_expire" required>

		<label for="u_note"><b>Примечание</b></label>
		<input type="text"" placeholder="Введите Примечание" name="u_note" required>


		<input type="submit" class="btn" value="Сохранить">
		<input type="button" class="btn cancel" onclick="closeForm()" value="Закрыть">
	  </form>
	</div>
</div>
<input type=button value="Добавить" onclick=openFormAsNew()>
</body>
</html>

