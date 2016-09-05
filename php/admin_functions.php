<?php

include 'dbconnect.php';
$site = strtolower(isset($_POST['site']) ? ($_POST['site']) : null);
$title = isset($_POST['title']) ? ($_POST['title']) : null;
$keywords = isset($_POST['keywords']) ? ($_POST['keywords']) : null;
$comicCategory = strtolower(isset($_POST['comicCat']) ? ($_POST['comicCat']) : null);
$artCategory = strtolower(isset($_POST['artCat']) ? ($_POST['artCat']) : null);
$description = isset($_POST['description']) ? ($_POST['description']) : null;
$cat = getCatId($site, $comicCategory, $artCategory);

//Get latest ID and add 1 to it...
$sql = "SELECT id FROM comics ORDER BY id DESC LIMIT 1";
$result = $mysqli->query($sql) or trigger_error($mysqli->error.$sql);
$row = $result->fetch_object();
$id = $row->id;
$id++;

//Insert
$sql = "INSERT INTO
                                $site (id, title, keywords, path, thumb, date, catidFK, description)
                            VALUES
                                ('$id', '$title.png', '$keywords', './images/$site/$cat/$title.png', '$title.png', NOW(), '$cat', '$description')";

$mysqli->query($sql) or trigger_error($mysqli->error.$sql);


echo "You've added ['$id', '$title.png', '$keywords', './images/$site/$cat/$title.png', '$title.png', NOW(), '$cat', '$description'] to the $site table";

header("refresh:5; url=../.?action=homepage");

//get correct category id given a certain category name
function getCatId($mySite, $comicCat, $artCat) {
	$catid = null;
	if ($mySite == "comics") {
		if ($comicCat= "charts") {
			$catid = "1";
		}
		elseif ($comicCat == "life") {
			$catid = "2";
		}
		elseif ($comicCat == "office") {
			$catid = "3";
		}
		elseif ($comicCat == "political") {
			$catid = "4";
		}
		elseif ($comicCat == "misc")  {
			$catid = "5";
		}
	}
	elseif ($mySite == "artwork") {
		if ($artCat == "3D") {
			$catid = "1";
		}
		elseif ($artCat == "Acrylic") {
			$catid = "2";
		}
		elseif ($artCat == "Graffiti") {
			$catid = "3";
		}
		elseif ($artCat == "References") {
			$catid = "4";
		}
		elseif ($artCat == "Sketch") {
			$catid = "5";
		}
		elseif ($artCat == "Vector") {
			$catid = "6";
		}
		else {
			$catid = "7";
		}
	}

	return $catid;
}


?>
