<?php 
	include 'includes/core/init.php';
	include_once('includes/overall/overall_header.php'); 

	if(isset($_GET['username']) && !empty($_GET['username'])){
		$username = $_GET['username'];
		if(user_exists($username)){
			$user_id = user_id_from_username($username);
			$profile_data = user_data($user_id, 'f_name', 'l_name', 'email');
?>
<h1><?php echo $profile_data['f_name']?>'s Profile</h1>
<p>Preferred Email: <?php echo $profile_data['email']?></p>
<?php
		} else {
			echo "Sorry the doesn't seem to be an account with the username " . $username;
		}
	} else {
		header('Location: index.php');
		exit();
	}
?>


<?php include_once('includes/overall/overall_footer.php'); ?>