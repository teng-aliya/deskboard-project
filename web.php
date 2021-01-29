<?php  
//This file is for the routing 
require_once 'controllers/AuthController.php';
require_once 'controllers/PostController.php';
require_once 'controllers/ChatController.php';

if($_SERVER["REQUEST_METHOD"] == "GET") {
	$uri = $_SERVER["REQUEST_URI"];
	$id = $_GET["id"];

	switch($uri){
		case "/web.php?id=$id":
			delete($id);
			break;
	}
} 


if($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST['action'];
	switch($action) {
		case "register":
			register($_POST);
			break;
		case "add_post":
			store($_POST);
			break;
		case "update":
			update($_POST);
		case "login":
			login($_POST);
			break;
		case "logout":
			logout();
			break;
		case "add_message":
			add_message($_POST);
			break;
	}
}

