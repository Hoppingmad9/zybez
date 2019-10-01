<?php

$testing = true;

include_once("header.php");

$clanListUrl = "http://services.runescape.com/m=clan-hiscores/members_lite.ws?clanName=zybeznet";

$clanListData = file_get_contents($clanListUrl);

$clanListData = explode("\n",$clanListData);

array_shift($clanListData);
array_pop($clanListData);

$clanList = [];

foreach($clanListData as $clanMemberInfo)
{
	$username = str_replace(chr(160)," ",explode(",",$clanMemberInfo)[0]);
	$checkUsernameQuery = "SELECT id FROM users WHERE username = '$username';";
	$checkUsrnameResult = $mysqli->query($checkUsernameQuery);
	if ($checkUsrnameResult->num_rows == 0)
	{
		$insertUsernameQuery = "INSERT INTO users(username, setup_state) VALUES ('$username', 1);";
		$insertUsernameResult = $mysqli->query($insertUsernameQuery);
		if (!$insertUsernameResult && $testing)
		{
			print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$invalidUsernameQuery\"");
		}
	}
}
