<?php

$tesing = true;

include_once("header.php");

$usersPerRun = $argv[1];

$getMembersQuery = "SELECT id, username, FROM users WHERE setup_state = 1 LIMIT $usersPerRun;";
$getMembersResult = $mysqli->query($getMembersQuery);

$getSkillsQuery = "SELECT `id` FROM `skills`";
$getSkillsResult = $mysqli->query($getSkillsQuery);

// put skills in array
if ($getSkillsResult->num_rows > 0)
{
	$skills = [];
	while ($skillId = $getSkillsResult->fetch_assoc())
	{
		$skillIds[] = $skill[0];
	}
}
else
{
	print_p("Error getting skills.");
}

if ($getMembersResult->num_rows > 0)
{
	while ($member = $getMembersResult->fetch_assoc())
	{
		$memberId = $member['id'];
		$username = $member['username'];
		foreach ($skillIds as $skillId)
		{
			$runemetricsSkillId = $skillId-2;
			$url = "https://apps.runescape.com/runemetrics/xp-monthly?searchName=$username&skillid=$runemetricsSkillId";
