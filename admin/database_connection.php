<?php

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

		$hostname = "localhost";
		$database = "runescape_tracker";
		$username = "rs_webmaster";
		$password = "%Nc47sp8";

		$mysqli = new mysqli($hostname, $username, $password, $database);
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
