<?php 
	include 'includes/core/init.php';

	protect_page();

	if(!empty($_POST)){
		$required_fields = array('new_pass', 'confirmed_pass');

		foreach($_POST as $key =>$value){
			if(empty($value) && in_array($key, $required_fields)){
				$errors[] = 'Fields marked with an asterisk are required';
				break 1;
			}
		} 
		if(trim($_POST['new_pass']) !== trim($_POST['confirmed_pass'])){
			$errors[] = 'The passwords do not match!';
		} else if (strlen($_POST['new_pass']) < 6){
			$errors[] = 'Passwords must be at least 6 characters in length.';
		}
	}

	include_once('includes/overall/overall_header.php'); 
?>
<h1>Change Password</h1> 

<?php
	if(isset($_GET['success']) && empty($_GET['success'])) {
		echo 'Password has been successfully changed.';
	} else {
		if(empty($errors) && !empty($_POST)){
			//change password
			change_password($session_user_id, $_POST['confirmed_pass']);
			header('Location: change_password.php?success');		
		} else if(!empty($errors)){
			//output errors
			output_errors($errors);
		}	

?>
<form action="" method="post">
	<ul>
		<li>
			New Password*:<br/>
			<input type="password" name="new_pass"/>
		</li>
		<li>
			Confirm Password*:<br />
			<input type="password" name="confirmed_pass"/>
		</li>
		<li>
			<input type="submit" value="Change Password"/>
		</li>
	</ul>
</form>

<?php 
}
include_once('includes/overall/overall_footer.php'); 
?>