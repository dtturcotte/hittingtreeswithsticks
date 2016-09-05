<?php 
/*
$mysqli = new mysqli("localhost", "root", "", "my_test_db_2014");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (Error code: " . $mysqli->connect_errno . ")... " . $mysqli->connect_error;
}
*/


//include 'config.php';

//$mysqli = new mysqli(DB_HOST, DB_UN, DB_PW, DB_NAME);
$mysqli = new mysqli("htwsplayground.db.9227744.hostedresource.com", "htwsplayground", "ChinaTea88!", "htwsplayground");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (Error code: " . $mysqli->connect_errno . ")... " . $mysqli->connect_error;
}

?>

