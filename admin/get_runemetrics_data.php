<?php

$testing = true;

function fix_int_overflow($int) {
	if ($int < 0) {
		$int += 2*2**31;
	}
	return $int;
}

function get_levels($skillXp, $skillId) {

	$levels = [
		"normal"=>[1=>0, 2=>83, 3=>174, 4=>276, 5=>388, 6=>512, 7=>650, 8=>801, 9=>969, 10=>1154, 11=>1358, 12=>1584, 13=>1833, 14=>2107, 15=>2411, 16=>2746, 17=>3115, 18=>3523, 19=>3973, 20=>4470, 21=>5018, 22=>5624, 23=>6291, 24=>7028, 25=>7842, 26=>8740, 27=>9730, 28=>10824, 29=>12031, 30=>13363, 31=>14833, 32=>16456, 33=>18247, 34=>20224, 35=>22406, 36=>24815, 37=>27473, 38=>30408, 39=>33648, 40=>37224, 41=>41171, 42=>45529, 43=>50339, 44=>55649, 45=>61512, 46=>67983, 47=>75127, 48=>83014, 49=>91721, 50=>101333, 51=>111945, 52=>123660, 53=>136594, 54=>150872, 55=>166636, 56=>184040, 57=>203254, 58=>224466, 59=>247886, 60=>273742, 61=>302288, 62=>333804, 63=>368599, 64=>407015, 65=>449428, 66=>496254, 67=>547953, 68=>605032, 69=>668051, 70=>737627, 71=>814445, 72=>899257, 73=>992895, 74=>1096278, 75=>1210421, 76=>1336443, 77=>1475581, 78=>1629200, 79=>1798808, 80=>1986068, 81=>2192818, 82=>2421087, 83=>2673114, 84=>2951373, 85=>3258594, 86=>3597792, 87=>3972294, 88=>4385776, 89=>4842295, 90=>5346332, 91=>5902831, 92=>6517253, 93=>7195629, 94=>7944614, 95=>8771558, 96=>9684577, 97=>10692629, 98=>11805606, 99=>13034431, 100=>14391160, 101=>15889109, 102=>17542976, 103=>19368992, 104=>21385073, 105=>23611006, 106=>26068632, 107=>28782069, 108=>31777943, 109=>35085654, 110=>38737661, 111=>42769801, 112=>47221641, 113=>52136869, 114=>57563718, 115=>63555443, 116=>70170840, 117=>77474828, 118=>85539082, 119=>94442737, 120=>104273167],
		"elite" => [1=>0, 2=>830, 3=>1861, 4=>2902, 5=>3980, 6=>5126, 7=>6390, 8=>7787, 9=>9400, 10=>11275, 11=>13605, 12=>16372, 13=>19656, 14=>23546, 15=>28138, 16=>33520, 17=>39809, 18=>47109, 19=>55535, 20=>64802, 21=>77190, 22=>90811, 23=>106221, 24=>123573, 25=>143025, 26=>164742, 27=>188893, 28=>215651, 29=>245196, 30=>277713, 31=>316311, 32=>358547, 33=>404634, 34=>454796, 35=>509259, 36=>568254, 37=>632019, 38=>700797, 39=>774834, 40=>854383, 41=>946227, 42=>1044569, 43=>1149696, 44=>1261903, 45=>1381488, 46=>1508756, 47=>1644015, 48=>1787581, 49=>1939773, 50=>2100917, 51=>2283490, 52=>2476369, 53=>2679907, 54=>2894505, 55=>3120508, 56=>3358307, 57=>3608290, 58=>3870846, 59=>4146374, 60=>4435275, 61=>4758122, 62=>5096111, 63=>5449685, 64=>5819299, 65=>6205407, 66=>6608473, 67=>7028964, 68=>7467354, 69=>7924122, 70=>8399751, 71=>8925664, 72=>9472665, 73=>10041285, 74=>10632061, 75=>11245538, 76=>11882262, 77=>12542789, 78=>13227679, 79=>13937496, 80=>14672812, 81=>15478994, 82=>16313404, 83=>17176661, 84=>18069395, 85=>18992239, 86=>19945833, 87=>20930821, 88=>21947856, 89=>22997593, 90=>24080695, 91=>25259906, 92=>26475754, 93=>27728955, 94=>29020233, 95=>30350318, 96=>31719944, 97=>33129852, 98=>34580790, 99=>36073511, 100=>37608773, 101=>39270442, 102=>40978509, 103=>42733789, 104=>44537107, 105=>46389292, 106=>48291180, 107=>50243611, 108=>52247435, 109=>54303504, 110=>56412678, 111=>58575823, 112=>60793812, 113=>63067521, 114=>65397835, 115=>67785643, 116=>70231841, 117=>72737330, 118=>75303019, 119=>77929820, 120=>80618654, 121=>83370445, 122=>86186124, 123=>89066630, 124=>92012904, 125=>95025896, 126=>98106559, 127=>101255855, 128=>104474750, 129=>107764216, 130=>111125230, 131=>114558777, 132=>118065845, 133=>121647430, 134=>125304532, 135=>129038159, 136=>132849323, 137=>136739041, 138=>140708338, 139=>144758242, 140=>148889790, 141=>153104021, 142=>157401983, 143=>161784728, 144=>166253312, 145=>170808801, 146=>175452262, 147=>180184770, 148=>185007406, 149=>189921255, 150=>194927409]];
	// TODO: get skill levels from db
	$eliteSkills = [28];
	$advancedSkills = [20,26,28];
	if (in_array($skillId, $eliteSkills)) {
		$skillType = "elite";
	}
	else {
		$skillType = "normal";
	}
	foreach ($levels[$skillType] as $rawLevel => $xp) {
		if ($skillXp < $xp) {
			$rawLevel--;
			break;
		}
	}
	if (in_array($skillId, $advancedSkills)) {
		$level = min(120, $rawLevel);
	}
	else {
		$level = min(99, $rawLevel);
	}
	$virtualLevel = $rawLevel;

	return [$level, $virtualLevel];
}

include_once("header.php");

$usersPerRun = 1;

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
		$abortUser = false;
		$memberId = $member['id'];
		$username = $member['username'];
		$processingUserQuery = "UPDATE users SET setup_state = 6, setup_state_change = NOW() WHERE id = $memberId;";
		$processingUserResult = $mysqli->query($processingUserQuery);
		if (!$processingUserResult) {
			print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$processingUserQuery\"", true);
		}
		$monthlyXp = [];
		foreach ($skillIds as $skillId) {
			$runemetricsSkillId = $skillId-2;
			$runemetricsUsername = str_replace(" ", "_", $username);
			$url = "https://apps.runescape.com/runemetrics/xp-monthly?searchName=$runemetricsUsername&skillid=$runemetricsSkillId";
			$jsonDataString = @file_get_contents($url);
			$data = json_decode($jsonDataString, true);
			if ($data == FALSE) {
				$testing ? print_p("$username not found.") : "";
				$invalidUsernameQuery = "UPDATE users SET setup_state = 3, setup_state_change = NOW() WHERE id = $memberId;";
				$invalidUsernameResult = $mysqli->query($invalidUsernameQuery);
				if (!$invalidUsernameResult) {
					print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$invalidUsernameQuery\"", true);
				}
				$abortUser = true;
				break;
			}
			else {
				$testing ? print_p("$username found.") : "";
				if (!isset($data["monthlyXpGain"][0]["skillId"])) {
					$testing ? print_p("$skillId not found.") : "";
					$invalidSkillIdQuery = "UPDATE users SET setup_state = 4, setup_state_change = NOW() WHERE id = $memberId;";
					$invalidSkillIdResult = $mysqli->query($invalidSkillIdQuery);
					if (!$invalidSkillIdResult) {
						print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$invalidSkillIdQuery\"", true);
					}
					$abortUser = true;
					break;
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
		if ($abortUser) {
			continue;
		}
		$testing ? print_p($monthlyXp) : "";$dates = [];
		$dateNow = new DateTime;
		$tempDate = new DateTime;
		$tempDate->modify("-1 year");
		while ($tempDate < $dateNow) {
			$tempDate->modify("+1 month");
			$dates[] = $tempDate->format("Y-m-01");
		}
		$xpTotalsData = [];
		$totalLevelData = [];
		foreach ($monthlyXp as $skillId => $months) {
			if ($skillId === 1) {
				continue;
			}
			elseif ($skillId === 28) {
				foreach ($months as $month => $xp) {
					$levels = get_levels($xp, $skillId);
					$level = $levels[0];
					$virtualLevel = $levels[1];
					$totalLevelData[$month]["level"] += $level;
					$totalLevelData[$month]["virtual_level"] += $virtualLevel;
					$monthStr = $dates[$month-1];
					$xpTotalsData[] = [$skillId, $monthStr, $level, $virtualLevel, $xp];
				}
			}
			else {
				foreach ($months as $month => $xp) {
					$levels = get_levels($xp, $skillId);
					$level = $levels[0];
					$virtualLevel = $levels[1];
					$totalLevelData[$month]["level"] += $level;
					$totalLevelData[$month]["virtual_level"] += $virtualLevel;
					$monthStr = $dates[$month-1];
					$xpTotalsData[] = [$skillId, $monthStr, $level, $virtualLevel, $xp];
				}
			}
		}
		foreach ($monthlyXp as $skillId => $months) {
			if ($skillId === 1) {
				foreach ($months as $month => $skillXp) {
					$monthStr = $dates[$month-1];
					$xpTotalsData[] = [$skillId, $monthStr, $totalLevelData[$month]["level"], $totalLevelData[$month]["virtual_level"], $skillXp];
				}
			}
			else {
				continue;
			}
		}
		$xpTotalInsertStatus = 2;

		foreach ($xpTotalsData as $key => $value) {
			$xpTotalsInsertQuery = "INSERT INTO stats (user, skill, date, level, virtual_level, xp) VALUES ($memberId, $value[0], '$value[1]', $value[2], $value[3], $value[4]);";
			$xpTotalsInsertResult = $mysqli->query($xpTotalsInsertQuery);
			if (!$xpTotalsInsertResult) {
				print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$xpTotalsInsertQuery\"", true);
				$xpTotalInsertStatus = 5;
			}
		}
		$xpTotalsInsertsResultQuery = "UPDATE users SET setup_state = $xpTotalInsertStatus, setup_state_change = NOW() WHERE id = $memberId;";
		$xpTotalsInsertsResultResult = $mysqli->query($xpTotalsInsertsResultQuery);
		if (!$xpTotalsInsertsResultResult) {
			print_p("Error: ".mysqli_error($mysqli).". From sql query - \"$xpTotalsInsertsResultQuery\"", true);
		}
	}
}
