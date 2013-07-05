<?php
	include 'includes/core/init.php';

	$test = 'test';
	if(user_exists('test')){
		echo 'exists';
	} else {
		echo 'does not exist';
	}
	if(empty($_POST) === false){
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($username) || empty($password)){
			$errors[] = 'You need to enter a username and password'; //appends a value to array 'errors'
		} else if (user_exists($username) === false){ //user_exists() is a custom created function.
			$errors[] = 'A user with this username doesn\'t appear to exist, have you registered yet?';
		}
	}
?>