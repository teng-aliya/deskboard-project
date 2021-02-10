<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<title> Deskboard | CHATROOM</title>
</head>

<?php 
date_default_timezone_set("Asia/Kuala_Lumpur");
require '../vendor/autoload.php';
use Carbon\Carbon;
session_start();
function get_content() {
	require_once '../controllers/connection.php';
	require_once '../controllers/ChatController.php';

	$id = $_GET['id'];
	$user_id = $_SESSION["user_details"]["user_id"];

	$user_query = "SELECT * FROM users INNER JOIN status ON users.status_id = status.status_id WHERE users.user_id = $id";
  	$user_stmt = $cn->prepare($user_query);
  	$user_stmt->execute();
  	$user_result = $user_stmt->get_result();
  	$room_user = $user_result->fetch_assoc();

  	$sender_query = "SELECT * FROM users INNER JOIN message ON users.user_id = message.user_one";
  	$sender_stmt = $cn->prepare($sender_query);
  	$sender_stmt->execute();
  	$sender_result = $sender_stmt->get_result();
  	$sender = $sender_result->fetch_assoc();

  	$messages = fetch_chat($id);
  	
?>
<div class="container chatroom col-lg-6 offset-3">
	<div>
		<div class="p-2 border-bottom">
			<img class="img-fluid rounded-circle mb-3" style="width: 80px; height: 80px;" src="<?php echo $_SESSION['user_details']['image']; ?>">
            <h4 class="m-3 d-inline-block">
                <?php echo $room_user['firstname']?>
                <?php echo " " ?>
                <?php echo $room_user['lastname'] ?>
                <small class="d-block"><?php echo $room_user['username'] ?></small>
            </h4>
            <?php if($room_user['status_name'] == 'Online'): ?>
            	<span class="badge bg-success">
	            	<?php echo $room_user['status_name'] ?>
	            	<br>
	            	<?php echo $room_user['status_description'] ?>
            	</span>	
            <?php else: ?>
            	<span class="badge bg-red">
	            	<?php echo $room_user['status_name'] ?>
	            	<br>
	            	<?php echo $room_user['status_description'] ?>
            	</span>	
            <?php endif ?>
		</div>
		<div class="panel mt-3">
			<div id="chat_area">
				<?php foreach ($messages as $message): ?>
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<?php if ($message['user_one'] == $user_id): ?>
					<div class="col-md-6 offset-6 badge bubble-1 my-3 message">
						<small>
							<?php echo $sender['firstname'] ?>
							<?php echo " " ?>
							<?php echo $sender['lastname'] ?>
						</small>
						<?php if ($message['image']): ?>
							<img class="img-fluid" src="<?php echo $message['image'] ?>">
						<?php endif ?>
						<p><?php echo $message['content'] ?></p>
						<small><?php echo Carbon::parse($message["date_sent"])->shiftTimezone("Asia/Kuala_Lumpur")->diffForHumans(); ?></small>
					</div>
				<?php elseif($message['user_two']): ?>
					<div class="col-md-6 badge bubble-2 my-3 message">
						<small>
							<?php echo $sender['firstname'] ?>
							<?php echo " " ?>
							<?php echo $sender['lastname'] ?>
						</small>
						<?php if ($message['image']): ?>
								<img class="img-fluid" src="<?php echo $message['image'] ?>">
						<?php endif ?>
						<p><?php echo $message['content'] ?></p>
						<small><?php echo Carbon::parse($message["date_sent"])->shiftTimezone("Asia/Kuala_Lumpur")->diffForHumans(); ?><small>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</div>
				
		<form class="input-group panel-form" id="send-message" action="../web.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="action" value="add_message">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="text" class="form-control" placeholder="Enter a message..." name="message">
			<input type="file" class="form-control" name="image">
			<button class="btn btn-outline-success" id="submit" type="submit">Send</button>
		</form>
				
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var auto_refresh = setInterval(
		function () {
		    var newcontent= `<?php foreach ($messages as $message): ?>
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<?php if ($message['user_one'] == $user_id): ?>
					<div class="col-md-6 offset-6 badge bubble-1 my-3 message">
						<small>
							<?php echo $sender['firstname'] ?>
							<?php echo " " ?>
							<?php echo $sender['lastname'] ?>
						</small>
						<?php if ($message['image']): ?>
							<img class="img-fluid" src="<?php echo $message['image'] ?>">
						<?php endif ?>
						<p><?php echo $message['content'] ?></p>
						<small><?php echo Carbon::parse($message["date_sent"])->shiftTimezone("Asia/Kuala_Lumpur")->diffForHumans(); ?></small>
					</div>
				<?php elseif($message['user_two']): ?>
					<div class="col-md-6 badge bubble-2 my-3 message">
						<small>
							<?php echo $sender['firstname'] ?>
							<?php echo " " ?>
							<?php echo $sender['lastname'] ?>
						</small>
						<?php if ($message['image']): ?>
								<img class="img-fluid" src="<?php echo $message['image'] ?>">
						<?php endif ?>
						<p><?php echo $message['content'] ?></p>
						<small><?php echo Carbon::parse($message["date_sent"])->shiftTimezone("Asia/Kuala_Lumpur")->diffForHumans(); ?><small>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>`;
		    $('#chat_area').html(newcontent);
		}, 1000);
})
</script>

<?php 
};
require_once 'partials/layout.php';
?>