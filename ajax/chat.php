<?php
require '../includes/core/init.php';
if(isset($_POST['method']) && !empty($_POST['method'])){
	$chat - new Chat();
	$method = trim($_POST['method']);
	if($method === 'fetch'){
		$messages = $chat->fetchMessages();

		if(empty($messages)){
			echo 'There are currently no messages in chat.';
		} else {
			foreach($messages as $message) {
				?>
				<div class="message">
					<a href-"#"> <?php echo $message['user_name']; ?></a> says:
					<p><?php echo $message['message']; ?></p>
			<?php
			}
		}
	} else if($method === 'throw'){
		//throw message into database
	}
}