<?php

include_once('db.php');

class databaseConnection
{
	function connect($cli = false, $testing = false)
	{
		if ($cli)
		{
			$nl = "\n";
		}
		else
		{
			$nl = "<br>";
		}
		
		$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$cacheOffQuery = "SET SESSION query_cache_type = OFF;";
		$mysqli->query($cacheOffQuery);

		if ($mysqli->connect_errno)
		{
			echo "Databse connection failed.".$nl;
		}
		else
		{
			if ($testing)
			{
				echo "Database connection okay.".$nl;
			}
		}

		$mysqli->set_charset('utf8');

		return $mysqli;
	}
}

?>
