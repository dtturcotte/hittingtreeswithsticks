<?php

//include 'config.php';

//$mysqli = new mysqli(DB_HOST, DB_UN, DB_PW, DB_NAME);
$mysqli = new mysqli("htws.db.9227744.hostedresource.com", "htws", "ChinaTea88!", "htws");

if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (Error code: " . $mysqli->connect_errno . ")... " . $mysqli->connect_error;
}

?>
