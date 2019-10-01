<?php

include_once 'cli_check.php';
include_once 'database_connection.php';

$cliCheck = new cliCheck;
$cli = $cliCheck->check();
if ($cli) {
	$nl = "\n";
	$tab = "\t";
}
else {
	$nl = "<br>";
	$tab = "&emsp";
}

$db = new databaseConnection;
$mysqli = $db->connect($cli, $testing);

if ($testing) {
	echo "cli: ".($cli ? "true" : "false").$nl;
	echo "db: ".($db ? "true" : "false").$nl;
}

function print_p($str, $log = false, $before = false) {
	global $nl;
	if ($log) {
		log_error($str);
	}
	if ($before)
	{
		echo $nl;
	}
	print_r($str);
	echo $nl;
}

function recursive_array_print($array, $level = 1){
	global $nl, $tab;
    foreach($array as $key => $value){
        //If $value is an array.
        if(is_array($value)){
            //We need to loop through it.
            recursive_array_print($value, $level + 1);
        } else{
            //It is not an array, so print it out.
            echo str_repeat($tab, $level), $value, $nl;
        }
    }
}

function log_error($str) {
	// TODO: write logging stuff
}


?>
