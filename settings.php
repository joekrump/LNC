<?php 
	include 'includes/core/init.php';
	protect_page();
	include_once('includes/overall/overall_header.php'); 

	if(!empty($_POST)){

		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'A valid email address is required';
		}
		if($user->email_exists($_POST['email']) && ($_POST['email'] != $user_data['email'])){
			$errors[] = 'This email address is already in use';
		}
		if(strlen($_POST['f_name']) > 32){
			$errors[] = 'You first name can be a maximum of 32 characters.';
		}
		if(strlen($_POST['l_name']) > 32){
			$errors[] = 'You last name can be a maximum of 32 characters.';
		}
	}
?>
<h1>Settings</h1> 
<?php 
if(isset($_GET['success'])){
	echo 'Your details have been updated!';
} else {
	if(!empty($_POST) && empty($errors) && (($_POST['f_name'] != $user_data['f_name']) || ($_POST['l_name'] != $user_data['l_name']) || ($_POST['email'] != $user_data['email']))){
		$update_data = array(
			'f_name' => $_POST['f_name'],
			'l_name' => $_POST['l_name'],
			'email' => $_POST['email']
		);

		$user->update_data($update_data);
		header('Location: settings.php?success');
		exit();

	} else if (!empty($errors)){
		echo output_errors($errors);
	}

	?>
	<form action="" method="post">
		<ul>
			<li>
				First name:<br/>
				<input type="text" name="f_name" value="<?php echo $user_data['f_name']; ?>" autofocus/>
			</li>
			<li>
				Last name:<br />
				<input type="text" name="l_name" value="<?php echo $user_data['l_name']; ?>" autofocus/>
			</li>
			<li>
				Email:<br />
				<input type="text" name="email" value="<?php echo $user_data['email']; ?>" autofocus/>
			<li>
				<input type="submit" value="Update"/>
			</li>
		</ul>
	</form>
<?php 
}
include_once('includes/overall/overall_footer.php'); 
?>