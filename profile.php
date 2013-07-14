<?php 
	include 'includes/core/init.php';
	include_once('includes/overall/overall_header.php'); 

	if(isset($_GET['username']) && !empty($_GET['username'])){
		$username = $_GET['username'];
		if($user->user_exists($username)){
			$user_id = $user->user_id_from_username($username);
			$profile_data = $user->user_data($user_id, 'f_name', 'l_name', 'email');
?>
<div id="public_profile">
	<h1><?php echo $profile_data['f_name']?>'s Profile</h1>
	<?php
		if(!empty($user_data['profile_pic'])){
			echo '<img src="' . $user_data['profile_pic'] . '" alt="' . $user_data['f_name'] . '"/>';
		}
	?>
	<div class="profile-info">
		<h3>Details:</h3>
		<p>Preferred Email: <?php echo $profile_data['email']?></p>
	</div>
</div>

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