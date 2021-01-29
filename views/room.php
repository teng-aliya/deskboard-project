<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<title> Deskboard | CHATROOM</title>
</head>

<?php 
session_start();
function get_content() {
	require_once '../controllers/connection.php';
	require_once '../controllers/ChatController.php';
	date_default_timezone_set("Asia/Kuala_Lumpur");

	if(!isset($_SESSION["user_details"])) {
	 	header("Location: /views/forms/login.php");
	};

	$id = $_GET['id'];
	$user_id = $_SESSION["user_details"]["user_id"];

	$query = "SELECT * FROM `message` WHERE `user_two` = $id ORDER BY date_sent asc";
    $stmt = $cn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC); 
?>

<div class="container chatroom col-lg-6 offset-3">
	<div>
		<div class="alert alert-primary alert-dismissible fade show" role="alert">
			<span class="ml-5">Welcome to Chatroom</span>
			<br>
			<span class="ml-5 small"><i>Note: Avoid using foul language and hate speech to avoid banning of account</i></span>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<div class="panel mt-3">
			<div class="chat_area">
				<?php foreach ($messages as $message): ?>
					<?php if ($message['user_one'] == $user_id): ?>
						<div class="col-md-6 offset-6 badge bubble-1 my-3">
							<?php if ($message['image']): ?>
								<img class="img-fluid" src="<?php echo $message['image'] ?>">
							<?php endif ?>
							<p><?php echo $message['content'] ?></p>
						</div>
					<?php elseif($message['user_two']): ?>
						<div class="col-md-6 badge bubble-2 my-3">
							<?php if ($message['image']): ?>
								<img class="img-fluid" src="<?php echo $message['image'] ?>">
							<?php endif ?>
							<p><?php echo $message['content'] ?></p>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
				
		<form class="input-group panel-form" action="../web.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="action" value="add_message">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="text" class="form-control" placeholder="Enter a message..." name="message">
			<input type="file" class="form-control" name="image">
			<button class="btn btn-outline-success" type="submit">Send</button>
		</form>
				
	</div>
</div>

<script type="text/javascript">

</script>
<?php 
};
require_once 'partials/layout.php';
?>