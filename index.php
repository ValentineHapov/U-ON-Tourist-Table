<?php
	include("header.php");
	
	$editForm = file_get_contents("edit-form-template.txt");
	$table = file_get_contents("table-template.txt");
	echo "Таблица со списком туристов<br>";
	echo $table;
	echo $editForm;
		
	echo "<input type=button value=\"Добавить\" onclick=openFormAsNew()>";
	include("footer.php");
?>
