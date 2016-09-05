<?php
ob_start();
session_start();

$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['pw']) ? $_POST['pw'] : "";


if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(verify($username, $password) == 1) {
			echo "<script>
			window.location.href='?action=admin';
			</script>";	
	}
	else {
		echo "<script>
			alert('WRONG!');
			window.location.href='?action=admin_login';
			</script>";	
	}
}

//need this to verify user's credentials so they don't just directly type in "?action=admin" to go to admin page... they need to be validated!
function verifyAdmin() {
	 if(!isset($_SESSION['username']) || !isset($_SESSION['permission_type']) || $_SESSION['permission_type'] != 'admin'){	
			echo "<script>
			window.location.href='?action=admin_login';
			</script>";	
    }
}

function verify($user, $pw) {
	include './php/dbconnect.php';

	$result = $mysqli->query("SELECT username, password FROM users WHERE username='" . $user . "' AND password='" . $pw . "'"); 
	
	if($result->num_rows == 1) {
		$_SESSION['username'] = $user;
		$_SESSION['permission_type'] = 'admin';
	}
	
	return $result->num_rows;
ob_end_flush();
}



?>