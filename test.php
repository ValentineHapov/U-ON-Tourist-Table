<?php

include_once __DIR__."/UON.php";

echo '<pre>';

$uon = new UON;

$time = time();

for ($i=0;$i<100;$i++)
{
	$res = $uon->getTouristsList(1);
	if ($res->status !== "success" || empty($res["result"]["users"]))
	{
		print_r($res);
		exit;
	}
}

print_r(time() - $time);