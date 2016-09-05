<?php
include 'dbconnect.php';
$site = $_GET['_site'];
$imgid = intval($_GET['_id']);
$input = $_GET['_choice'];

$likeimage = "<img src='./images/SiteDesign/";
$dislikeimage = "<img src='./images/SiteDesign/";

/*
$likeimage = "'./images/SiteDesign/";
$dislikeimage = "'./images/SiteDesign/";*/

if ($site == "artwork") {
	$table = "artwork";
}
else {
	$table = "comics";
}


$result = $mysqli->query("SELECT like_count, dislike_count FROM $table WHERE id = $imgid");

//put the counts into a list
list($likes, $dislikes) = $result->fetch_array(MYSQLI_NUM);

$check = "SELECT ip, tablename, imgid FROM votes WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND tablename = '$table' AND imgid = $imgid";

$result = $mysqli->query($check);

if ($result->num_rows == 0) { //if user hasn't voted yet, insert their choice
	$sql = "INSERT INTO
            votes (ip, tablename, imgid, vote, date)
        VALUES
            (\"".$_SERVER['REMOTE_ADDR']."\", \"$table\", $imgid, \"$input\", NOW())
        ON DUPLICATE KEY UPDATE
            imgid = VALUES(imgid)";

	if (!$mysqli->query($sql)) printf("Error: %s\n", $mysqli->error);

	if ($input == "like") {
		$sql = "UPDATE $table SET like_count = like_count + 1 WHERE id = $imgid";
		$mysqli->query($sql);
		$likes++;
		$likeimage.= "liked.png' id='like' onclick='callBoth(this.id)'/> ";
		$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
	}
	else if ($input == "dislike") {
		$sql = "UPDATE $table SET dislike_count = dislike_count + 1 WHERE id = $imgid";
		$mysqli->query($sql);
		$dislikes++;
		$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		$dislikeimage.= "disliked.png' id='dislike' onclick='callBoth(this.id)'/> ";
	}
}
else { //"unlike" their previous vote for that given image id

	$sql = "SELECT ip, tablename, imgid, vote FROM votes WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND tablename = '$table' AND imgid = $imgid";
	$result = $mysqli->query($sql);

	$row = $result->fetch_assoc();

	//if choose dislike, and there's a like in db, remove like and add dislike
	if (($input == "dislike") && ($row['vote'] == "like")) {
		$sql = "UPDATE $table SET like_count = like_count - 1, dislike_count = dislike_count + 1 WHERE id = $imgid";
		$mysqli->query($sql);
		$sql = "UPDATE votes SET vote = 'dislike' WHERE vote = 'like' AND imgid = $imgid";
		$mysqli->query($sql);
		$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		$dislikeimage.= "disliked.png' id='dislike' onclick='callBoth(this.id)'/> ";
	}
	//if choose like, and there's a dislike in db, remove dislike and add like
	else if (($input == "like") && ($row['vote'] == "dislike")) {
		$sql = "UPDATE $table SET like_count = like_count + 1, dislike_count = dislike_count - 1 WHERE id = $imgid";
		$mysqli->query($sql);
		$sql = "UPDATE votes SET vote = 'like' WHERE vote = 'dislike' AND imgid = $imgid";
		$mysqli->query($sql);
		$likeimage.= "liked.png' id='like' onclick='callBoth(this.id)'/> ";
		$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
	}

	//if choose like and user has liked before, remove it
	else if ((($input == "like") && ($row['vote'] == "like")) || (($input == "dislike") && ($row['vote'] == "dislike")))
	{
		$sql = "DELETE FROM
                        votes
                    WHERE (ip, tablename, imgid, vote) =
                        (\"".$_SERVER['REMOTE_ADDR']."\", \"$table\", $imgid, \"$input\")";

		if (!$mysqli->query($sql)) printf("Error: %s\n", $mysqli->error);


		if ($input == "like") { //remove like
			$sql = "UPDATE $table SET like_count = like_count - 1 WHERE id = $imgid";
			$mysqli->query($sql);
			$likes--;
			$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)' /> ";
			$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		}
		else if ($input == "dislike") {
			$sql = "UPDATE $table SET dislike_count = dislike_count - 1 WHERE id = $imgid";
			$mysqli->query($sql);
			$dislikes--;
			$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
			$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		}
	}
}

$result = $mysqli->query("SELECT like_count, dislike_count FROM $table WHERE id = $imgid");

//put the counts into a list
list($likes, $dislikes) = $result->fetch_array(MYSQLI_NUM);

echo $likeimage . " " . $dislikeimage;
echo "<br />";
echo  "<p>" . $likes . "<span class='votespacer'>" . $dislikes . "</span></p>";




mysqli_close($mysqli);

?>
