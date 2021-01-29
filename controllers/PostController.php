<?php  
session_start();
require_once 'connection.php';

//ADD POST
function store($request) {
	global $cn;
	$title = $request["title"];
	$description = $request["description"];
	$tag = $request["tag_id"];

	//Get all image properties and store it as a variable.
	$img_name = $_FILES["image"]["name"];
	$img_size = $_FILES["image"]["size"];
	$img_tmpname = $_FILES["image"]["tmp_name"];
	$img_path = "/assets/post/$img_name";

	$user_id = $_SESSION["user_details"]["user_id"];

	$img_type = pathinfo($img_name, PATHINFO_EXTENSION); //png, jpg, svg
	$is_img = false;
	$has_details = false; 

	//Did the user upload an image
	if($img_type == "jpg" || $img_type == "png" || $img_type == "jpeg" || $img_type == "svg" || $img_type == "gif") {
		$is_img = true;
	} else {
		echo "Please upload an image file";
	}

	//Did the user typed in some details for the title and description
	if(strlen($title) > 0 && strlen($description) > 0 && strlen($tag) > 0) {
		$has_details = true;
	}
	//Store the post in the database
	if($has_details && $is_img && $img_size > 0) {
		move_uploaded_file($img_tmpname, $_SERVER["DOCUMENT_ROOT"] . $img_path);

		$query = "INSERT INTO post(tag_id, title, description, image, user_id) VALUES (?, ?, ?, ?, ?)";
	    $stmt = $cn->prepare($query);
	    $stmt->bind_param("isssi", $tag, $title, $description, $img_path, $user_id);
	    $stmt->execute();
	    $stmt->close();
	    $cn->close();
		header("Location: ". $_SERVER['HTTP_REFERER']);
	}
}

//GET ALL POST
function index() {
	global $cn;
	$query = "SELECT * FROM post";
	$result = mysqli_query($cn, $query);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $posts;
}

function get_own_posts($id){
	global $cn;
	$query = "SELECT * FROM post WHERE user_id = $id";
	$result = mysqli_query($cn, $query);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $posts;
}


//DELETE POST
function delete($id){
	global $cn;
	$query = "DELETE FROM post where id = $id";
	mysqli_query($cn, $query);
	mysqli_close($cn);
	header("Location: ". $_SERVER['HTTP_REFERER']);
}
//UPDATE POST
function update($request) {
	global $cn;
	$title = $request['title'];
	$description = $request['description'];
	$current_image = $request['image'];
	$id = $request['id'];

	//If the user wants to also update the image
	if($_FILES['image']['name'] != "") {
		$image_path = "/assets/img/".$_FILES['image']['name'];
		move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $image_path);
		$query = "UPDATE post SET title = '$title', description='$description', image = '$image_path' WHERE id = $id";
		$stmt = $cn->prepare($query);
	    $stmt->bind_param("isssi", $tag, $title, $description, $img_path, $user_id);
	    $stmt->execute();
	    $stmt->close();
	    $cn->close();
		header("Location: ". $_SERVER['HTTP_REFERER']);
	} else {
		$query = "UPDATE post SET title = '$title', description = '$description' WHERE id = $id";
		$stmt = $cn->prepare($query);
	    $stmt->bind_param("isssi", $tag, $title, $description, $img_path, $user_id);
	    $stmt->execute();
	    $stmt->close();
	    $cn->close();
		header("Location: ". $_SERVER['HTTP_REFERER']);
	}
}