<?php 
require 'ChatController.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST['action'];
	$id = $_GET["id"];
	switch($action) {
		case "show_chat":
			json_encode(fetch_chat($id))
			break;
		case 'update_chat':
			add_message($_POST['message'], $_POST['image'], $_POST['id']);
			fetch_chat($id)
			break;
	}
}
?>