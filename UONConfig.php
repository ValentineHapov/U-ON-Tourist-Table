<?php

class UONConfig {
	const APIKey = "yUM50Pq2sLs2cY5R6jz71644506654";
	static protected $lastConnect;
	
	public function __construct()
	{
		$lastConnect = time();
	}
	
	protected function getAPIKey()
	{
		return self::APIKey;
	}
}