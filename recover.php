<?php 
include 'includes/core/init.php';
logged_in_user_redirect();
include_once('includes/overall/overall_header.php'); 
?>

<h1>Recover</h1>
<?php
if(isset($_GET['success'])){
?>
	<p>Check your email for the information you requested.</p>
<?php
} else {
	$modes = array('password', 'username');
	if(isset($_GET['mode']) && in_array($_GET['mode'], $modes)){
		if(isset($_POST['email']) && !empty($_POST['email'])){
			if($user->email_exists($_POST['email'])){
				$user->recover_info($_GET['mode'], $_POST['email']);
				header('Location: recover.php?success');
			} else {
				echo '<p>Oops, that isn\'t an email address that is registered with us!';
			}
		}
	?>

		<form action="" method="post">
		<ul>
			<li>
				Please enter your email address:<br />
				<input type="text" name="email"/>
			</li>
			<li>
				<input type="submit" value="Recover"/>
			</li>				
		</ul>
	</form> 

	<?php
	} else {
		header('Location: index.php');
		exit();
	}
}
include_once('includes/overall/overall_footer.php'); 
?>
