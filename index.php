<?php
/*Index page: directs you to appropriate template based on URL action parameter*/
include './config.php';
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch($action) {
	case 'allimages':
		allimages();
		break;
	case 'viewimage':
		viewimage();
		break;
	case 'about':
		about();
		break;
	case 'terms':
		terms();
		break;
	case 'admin_login':
		admin_login();
		break;
	case 'login':
		login();
		break;
	case 'admin':
		admin();
		break;
	case 'playground' :
		playground();
		break;
	default:
		homepage();
}

function allimages() {
	require(TEMPLATE_PATH . "/allimages.php");
}

function viewimage() {
	require(TEMPLATE_PATH . "/viewimage.php");
}

function about() {
	require(TEMPLATE_PATH . "/about.php");
}

function terms() {
	require(TEMPLATE_PATH . "/terms.php");
}

function admin_login() {
	require(TEMPLATE_PATH . "/admin_login.php");
}

function login() {
	require(TEMPLATE_PATH . "/login.php");
}

function admin() {
	require(TEMPLATE_PATH . "/admin.php");
}

function playground() {
	require("./playground/playground.php");
}

function homepage() {
	require(TEMPLATE_PATH . "/homepage.php");
}

?>
