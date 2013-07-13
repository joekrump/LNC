<?php 
include 'includes/core/init.php';
protect_page();
include_once('includes/overall/overall_header.php'); 
//check to make sure that the user can only access their own chat page.
if(!isset($_GET['mode']) || ($_GET['mode'] != $user_data['email_code'])){
	header('Location: index.php');
	exit();
} else {
	
?>
<h1>Chat</h1> 

<div class="chat">
	<div class="messages">
		<div class="message">
			<a href="">Username says:</a>
			<p>Message placeholder.</p>
		</div>
	</div>
	<textarea class="entry" placeholder="Hit Enter to send message or Shift+Enter for a newline."></textarea>
</div> 
<?php 
}
	include_once('includes/overall/overall_footer.php'); 
?>