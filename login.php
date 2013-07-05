<?php
	include 'includes/core/init.php';
	logged_in_user_redirect();
	include 'includes/overall/overall_header.php';

	if(empty($_POST) === false){
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($username) || empty($password)){
			$errors[] = 'You need to enter a username and password'; //appends a value to array 'errors'
		} else if (!user_exists($username)){ //user_exists() is a custom created function.
			$errors[] = 'A user with this username doesn\'t appear to exist, have you registered yet?';
		} else if (!user_active($username)){
			$errors[] = 'You haven\'t activated your account yet.';
		} else {
			if(strlen($username) > 32){
				$errors[] = 'Username too long.';
			} 
			//TODO: validation
			$login = login($username, $password); //will return false on failed login, else returns user_id
			if($login === false){
				$errors[] = 'That username/password combination was incorrect';
			} else {
				echo 'OK!';
				$_SESSION['user_id'] = $login; //set the user session
				header('Location: index.php'); //redirect user to home. 
				exit();
			}
		}
		if(!empty($errors)){
			echo '<h3>We couldn\'t log you in because: </h3>';
			echo output_errors($errors);
		}
	}
	include 'includes/overall/overall_footer.php';
?>