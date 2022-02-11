<?php 
	include("UON.php");
	$page=1;
	if (isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	
	$uon = new UON();
	
	print_r(json_encode($uon->getTouristsList($page)));