<?php
session_start();
include 'dbconnect.php';
mysqli_set_charset($mysqli, "utf8");

$functionToRun = (isset($_GET['_functionToRun']) ? ($_GET['_functionToRun']) : 0); 
$currLevel = (isset($_GET['_currLevel']) ? ($_GET['_currLevel']) : "mymap"); 
$currQuest = (isset($_GET['currQuest']) ? ($_GET['currQuest']) : "mymap"); 
$playerX = (isset($_GET['_playerX']) ? ($_GET['_playerX']) : 0); 
$playerY = (isset($_GET['_playerY']) ? ($_GET['_playerY']) : 0); 
$experience = (isset($_GET['_experience']) ? ($_GET['_experience']) : 0); 
$health = (isset($_GET['_health']) ? ($_GET['_health']) : 0); 
$items = (isset($_GET['_items']) ? ($_GET['_items']) : 0); 

//////////////////////LOAD ALL CURRENT MAP DATA ON USER LOGIN

if ($functionToRun == "loadUserStatsOnLOGIN") {
	$allData = array();
	
	$qry = 
		'SELECT qi.* 
		FROM quest_items qi
		LEFT JOIN user_quest_items uqi ON (qi.item_id = uqi.item_id)
		WHERE uqi.user_id = "' . $_SESSION['userid'] . '"';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
	
	while ($row = $result->fetch_assoc()) {
		$itemsArray[] = $row;
	}	

	$qry = 
		'SELECT us.* 
		FROM user_stats us
		WHERE us.user_id_fk = "' . $_SESSION['userid'] . '"';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
	
	while ($row = $result->fetch_assoc()) {
		$statsArray[] = $row;
	}	
	
	array_push($allData, $itemsArray, $statsArray);
	
	echo json_encode($allData);
}

else if ($functionToRun == "saveUserStats") {
	foreach ($items as $itemAmt => $itemName) {
		$itemAmounts[] = (int)$itemAmt;
		$itemNames[] = $itemName;	
	}

	$qry = 
		'UPDATE user_stats 
		SET levelname 	= "'.$currLevel.'",
			player_x		= "'.$playerX.'", 
			player_y		= "'.$playerY.'", 
			experience	= "'.$experience.'", 
			health		= "'.$health.'"	
		WHERE user_id_fk ="' . $_SESSION['userid'] . '"';	
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
			
	foreach ($items as $itemAmt => $itemName) {
		$qry = 
			'UPDATE user_quest_items uqi 
			INNER JOIN user_stats us ON (uqi.item_name = "' .$itemName . '")
			SET item_amount	= "'.  (int)$itemAmt .'"
			WHERE uqi.user_id = "' .$_SESSION['userid'] . '"';			
		$result = $mysqli->query($qry) or die(mysqli_error($mysqli));	
	}
		
	echo "data saved...";
	
}


else if ($functionToRun == "loadStatsOnDemand_X") {
	//query against userstats currentquestnum... get all previous quest data...
	$allDataArray = array();
	
	//get all completed levels
	$qry = 
		'SELECT ucl.*, l.*
		FROM user_completed_levels ucl
		INNER JOIN user_stats us ON (us.user_id_fk = ucl.user_id)
		INNER JOIN levels l ON (l.level_id = ucl.level_id)
		WHERE us.user_id_fk = "' . $_SESSION['userid'] . '"';	
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));	
	
	while ($row = $result->fetch_assoc()) {
		$completedLevelData[] = $row;
	//	var_dump($row);
	}
	
	$qry = 
		'SELECT ucq.*, q.*
		FROM user_completed_quests ucq
		INNER JOIN user_stats us ON (us.user_id_fk = ucq.user_id)
		INNER JOIN quests q ON (q.quest_id = ucq.quest_id)
		WHERE us.user_id_fk = "' . $_SESSION['userid']. '"';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));	
	
	//now I have all completed quest IDs per player ID
	//loop through quests
	while ($row = $result->fetch_assoc()) {
		$completedQuestData[] = $row;
		$tempArray = explode(" ", $row['npc_id']);
		$completedNPCs[] = $tempArray;	
	}
	
	foreach ($completedNPCs as $item) {
		foreach ($item as $value) {
			$allNPCIDs[] = $value;
		}
	}
	//get all NPCs per quest
	$qry = 
		'SELECT n.*
		FROM npcs n
		WHERE npc_id IN ("' . implode('", "', $allNPCIDs) . '")';

//	var_dump($qry);
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));	
	
	while ($row = $result->fetch_assoc()) {
	//	var_dump($row);
		$completedNPCData[] = $row;
	}
	//var_dump($completedNPCData);
	array_push($allDataArray, $completedLevelData, $completedQuestData, $completedNPCData);
	
	echo json_encode($allDataArray);	
	
}

/*
else if ($functionToRun == "loadStatsOnDemand") {
	$allArrays = array(); //stores array of all arrays containing data

	//GET CURRENT LEVEL INFO PER PLAYER ID (in user_stats)
	$qry = 
		'SELECT levels.* 
		FROM levels
		LEFT JOIN user_stats ON (user_stats.levelname = levels.levelname)
		WHERE user_stats.user_id_fk = "' . $playerID . '"';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
	
	$row = $result->fetch_assoc();
	$maxLevels = (int)$row['level_id'];
	
	//maxLevels: the level id that will serve as loop limit 
	$maxLevels--; //only want data before current map
	
	//query with map ID as limit... so it won't return maps that user hasn't finished...
	$qry = 
		'SELECT levels.* 
		FROM levels';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));

	$i = 0;
	
	//LOAD QuestIDs per completed level into array
	while (($i < $maxLevels) && ($row = $result->fetch_assoc())) {
		$completedLevelNames[] = $row['levelname'];
		$completedQuestIDs[] = $row['associatedQuestIDs'];
		$tempArray = explode(" ", $completedQuestIDs[$i]);
		$newArray[] = $tempArray;
		$levelData[] = $row;		
		$i++;
	}	
	
	//load NPCs per completed quest
	$qry = 
		'SELECT quests.* 
		FROM quests	
		';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));

	$i = 0;
	while (($i < count($newArray[$maxLevels-1])) && ($row = $result->fetch_assoc())) {
		$completedQuestNames[] = $row['quest_id'];
		$questData[] = $row;
		$tempArray = explode(" ", $row['npc_id']);
		$allNPCIDsPerQuest[] = $tempArray;		
		$i++;
	}
	foreach ($allNPCIDsPerQuest as $item) {
		foreach ($item as $value) {
			$allNPCIDs[] = $value;
		}
	}

	$qry = 
		'SELECT npcs.* 
		FROM npcs	
		WHERE npc_id IN ("' . implode('", "', $allNPCIDs) . '")';
	
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));

	$i = 0;

	while ($row = $result->fetch_assoc()) {
		$completedNPCNames[] = $row['npc_name'];
		$i++;
	}	
	array_push($allArrays, $completedLevelNames, $completedQuestNames, $completedNPCNames);
	
	echo json_encode($allArrays);
}
*/

else if ($functionToRun == "loadTask") {	
	$qry = 
		'SELECT * 
		FROM tasks
		WHERE npc_id_fk = 1';
		
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
	
	while ($row = $result->fetch_assoc()) {
		echo json_encode($row);
	}	
}

/////////////////////////////

function checkLogin($username, $password) {
	include 'DbConnect.php';

	$qry = "SELECT username, password FROM users WHERE username='$username' and password='$password'";	
	$result = $mysqli->query($qry) or die(mysqli_error($mysqli));
		
	if(!$result || mysqli_num_rows($result) <= 0) {
		return false;
	}
	return true;
}
?>