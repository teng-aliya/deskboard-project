<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
function get_content(){
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

<div class="message">
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

<?php 
}
require_once 'partials/layout.php';
 ?>