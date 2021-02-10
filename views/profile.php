<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<title> Deskboard | PROFILE</title>
</head>

<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
function get_content(){
	 require '../controllers/connection.php';

	 $user_id = $_SESSION["user_details"]["user_id"]; 

	 $query = "SELECT * FROM users WHERE user_id = $user_id";
     $stmt = $cn->prepare($query);
     $stmt->execute();
     $result = $stmt->get_result();
     $user = $result->fetch_assoc();
?>

<div class="container col-sm-6 offset-3 my-3">
	<div class="card">
	  <div class="card-header">
	    <img class="card-img-top img-fluid" src="<?php echo $user['image'] ?>">
	  </div>
	  <div class="card-body">
	    <h5 class="card-title text-center">Profile</h5>
	    <ul class="list-group list-group-flush">
		    <li class="list-group-item"><b>Name:</b> <?php echo $user['firstname'] ?> <?php echo $user['lastname']; ?></li>
		    <li class="list-group-item"><b>Username:</b> <?php echo $user['username'] ?></li>
		    <li class="list-group-item"><b>Email:</b> <?php echo $user['email'] ?></li>
	  	</ul>
	  </div>
	</div>
</div>

<?php 
}
require_once 'partials/layout.php';
 ?>