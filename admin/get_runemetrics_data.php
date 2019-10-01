<?php

$testing = false;

function fix_int_overflow($int) {
	if ($int < 0) {
		$int += 2*2**31;
	}
	return $int;
}

include_once("header.php");

$usersPerRun = $argv[1];

$getMembersQuery = "SELECT id, username FROM users WHERE setup_state = 1 LIMIT $usersPerRun;";
$getMembersResult = $mysqli->query($getMembersQuery);

$getSkillsQuery = "SELECT `id` FROM `skills`";
$getSkillsResult = $mysqli->query($getSkillsQuery);

// put skills in array
if ($getSkillsResult->num_rows > 0) {
	$skillIds = [];
	while ($skillId = $getSkillsResult->fetch_assoc()) {
		$skillIds[] = $skillId['id'];
	}
}
else {
	print_p("Error getting skills.");
}

if ($getMembersResult->num_rows > 0) {
	while ($member = $getMembersResult->fetch_assoc()) {
		$memberId = $member['id'];
		$username = $member['username'];
		$monthlyXp = [];
		foreach ($skillIds as $skillId) {
			$runemetricsSkillId = $skillId-2;
			$runemetricsUsername = str_replace(" ", "_", $username);
			$url = "https://apps.runescape.com/runemetrics/xp-monthly?searchName=$runemetricsUsername&skillid=$runemetricsSkillId";
			$jsonDataString = @file_get_contents($url);
			if ($jsonDataString === FALSE) {
				$testing ? print_p("$username not found.") : "";
				$invalidUsernameQuery = "UPDATE users SET setup_state = 3 WHERE id = $memberId;";
				$invalidUsernameResult = $mysqli->query($invalidUsernameQuery);
				if (!$invalidUsernameResult) {
					print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$invalidUsernameQuery\"", true);
				}
				break;
			}
			else {
				$testing ? print_p("$username found.") : "";
				$data = json_decode($jsonDataString, true);
				if (!isset($data["monthlyXpGain"][0]["skillId"])) {
					$testing ? print_p("$skillId not found.") : "";
					$invalidSkillIdQuery = "UPDATE users SET setup_state = 4 WHERE id = $memberId;";
					$invalidSkillIdResult = $mysqli->query($invalidSkillIdQuery);
					if (!$invalidSkillIdResult) {
						print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$invalidSkillIdQuery\"", true);
					}
				}
				else {
					$testing ? print_p("$skillId found.") : "";
					$totalXp = fix_int_overflow($data["monthlyXpGain"][0]["totalXp"]);
					$monthlyXpGains = $data["monthlyXpGain"][0]["monthData"];
					array_pad($monthlyXpGains, 12, ["xpGain"=>0,"timestamp"=>0,"rank"=>0]);
					$startMonthTotalXp = $totalXp;
					for ($month = 12; $month > 0 ; $month--) {
						$startMonthTotalXp -= fix_int_overflow($monthlyXpGains[$month-1]["xpGain"]);
						$monthlyXp[$skillId][$month] = $startMonthTotalXp;
					}
				}
			}
		}
		$testing ? print_p($monthlyXp) : "";$dates = [];
		$dateNow = new DateTime;
		$tempDate = new DateTime;
		$tempDate->modify("-1 year");
		while ($tempDate < $dateNow) {
			$tempDate->modify("+1 month");
			$dates[] = $tempDate->format("Y-m-01");
		}
		$xpTotalInsertStatus = 2;
		foreach ($monthlyXp as $skillId => $months) {
			foreach ($months as $month => $xp) {
				$monthStr = $dates[$month-1];
				$xpTotalsInsertQuery = "INSERT INTO stats (user, skill, date, xp) VALUES ($memberId, $skillId, '$monthStr', $xp);";
				$xpTotalsInsertResult = $mysqli->query($xpTotalsInsertQuery);
				if (!$xpTotalsInsertResult) {
					print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$xpTotalsInsertQuery\"", true);
					$xpTotalInsertStatus = 5;
				}
			}
		}
		$xpTotalsInsertsResultQuery = "UPDATE users SET setup_state = $xpTotalInsertStatus WHERE id = $memberId;";
		$xpTotalsInsertsResultResult = $mysqli->query($xpTotalsInsertsResultQuery);
		if (!$xpTotalsInsertsResultResult) {
			print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$xpTotalsInsertsResultQuery\"", true);
		}
	}
}
