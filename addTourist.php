<?php 
	include("UON.php");
	$uon = new UON();

	if(isset($_POST['u_id']))
	{
		print_r(json_encode($uon->updateTourist($_POST)));
	}
	else
	{
		print_r(json_encode($uon->addTourist($_POST)));
	}