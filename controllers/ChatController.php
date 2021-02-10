<?php 
require 'connection.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

function add_message($request){
	global $cn;
	$message = $request["message"];
	$date_sent = date('hisa');
	$id = $request['id'];
	$timestamp = date('Y:m:d H:i:s');

	//Get all image properties and store it as a variable.
	$img_name = $_FILES["image"]["name"];
	$img_size = $_FILES["image"]["size"];
	$img_tmpname = $_FILES["image"]["tmp_name"];
	$img_path = "/assets/message/$img_name";

	$user_id = $_SESSION["user_details"]["user_id"];

	$img_type = pathinfo($img_name, PATHINFO_EXTENSION); //png, jpg, svg
	$is_img = false;
	$has_details = false; 

	//Did the user upload an image
	if($img_type == "JPG" || $img_type == "jpg" || $img_type == "PNG" || $img_type == "png" || $img_type == "JPEG" || $img_type == "jpeg" || $img_type == "SVG" || $img_type == "svg" || $img_type == "gif" || $img_type == "GIF") {
		$is_img = true;
	}

	//Did the user typed in a message
	if(strlen($message) > 0) {
		$has_details = true;
	}
	//Store the post in the database
	if($has_details && $is_img && $img_size > 0) {
		move_uploaded_file($img_tmpname, $_SERVER["DOCUMENT_ROOT"] . $img_path);

		$query = "INSERT INTO message(user_one, user_two, content, image, date_sent) VALUES (?, ?, ?, ?, ?)";
	    $stmt = $cn->prepare($query);
	    $stmt->bind_param("iisss", $user_id, $id, $message, $img_path, $timestamp);
	    $stmt->execute();
	    $stmt->close();
	} else if($has_details){
		$query = "INSERT INTO message(user_one, user_two, content, date_sent) VALUES (?, ?, ?, ?)";
	    $stmt = $cn->prepare($query);
	    $stmt->bind_param("iiss", $user_id, $id, $message, $timestamp);
	    $stmt->execute();
	    $stmt->close();
	}

	$cn->close();
	header("Location: ". $_SERVER['HTTP_REFERER']);
}

function fetch_chat($id){
	global $cn;
	$query = "SELECT * FROM message WHERE user_two = $id ORDER BY date_sent ASC";
    $stmt = $cn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    return $messages;
}
?>