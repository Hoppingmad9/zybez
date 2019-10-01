<?php

include_once 'cli_check.php';
include_once 'database_connection.php';

$cliCheck = new cliCheck;
$cli = $cliCheck->check();
if ($cli)
{
	$nl = "\n";
}
else
{
	$nl = "<br>";
}

$db = new databaseConnection;
$mysqli = $db->connect($cli, $testing);

if ($testing)
{
	echo "cli: ".($cli ? "true" : "false").$nl;
	echo "db: ".($db ? "true" : "false").$nl;
}

function print_p($str,$before = true)
{
	global $nl;
	if ($before)
	{
		echo $nl;
	}
	print_r($str);
	echo $nl;
}

?>
