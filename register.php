<?php 
include 'includes/core/init.php';
logged_in_user_redirect();
include_once('includes/overall/overall_header.php'); 

// registration validation
if(!empty($_POST)){
	// array containing fields that require a value upon registration.
	$req_fields = array('username','password','f_name','email');
	
	foreach($_POST as $key => $value){
		//if the value is empty and it is a required field.
		if(empty($value) && in_array($key, $req_fields)){ 
			$errors[] = 'Fields marked with an asterisk are required';
			break 1;
		}
	}
	if(empty($errors)){
		//Check to see if a username contains any spaces. 
		if(preg_match("/\s/", $_POST['username'])){
			$errors[] = 'Usernames may not contain spaces.';
		}
		//check that user doesn't already exist.
		if(user_exists($_POST['username'])){
			//htmlentities sanitized html code from output content.
			$errors[] = 'Sorry, \'' . htmlentities($_POST['username']) . '\' is already taken.'; 
		}
		//check password length
		if(strlen($_POST['password']) < 6){
			$errors[] = 'Passwords must be at least 6 characters in length.';
		}
		//check username length.
		if(strlen($_POST['username']) < 3){
			$errors[] = 'Usernames must be at least 3 characters in length.';
		}
		//email validation checking rough email address string.
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'A valid email address is required';
		}
		//check to see if another user already is using this email address.
		if(email_exists($_POST['email'])){
			$errors[] = 'This email address is already in use';
		}
	}
} if(isset($_GET['success']) && empty($_GET['success'])) {
		echo 'You\'ve been successfully registered. Check your email to activate your account.';
	} else {
		//register new user if these are true
		if(empty($errors) && !empty($_POST)){
			
			$registration_info = array(
				'user_name' => $_POST['username'],
				'password' => $_POST['password'],
				'f_name' => $_POST['f_name'],
				'l_name' => $_POST['l_name'],
				'email' => $_POST['email'],
				'email_code' => md5($_POST['username'] + microtime())//create a unique email code
			);
			if(isset($_GET['r'])){
				$referral_code = $_GET['r'];
				register_referred_user($registration_info, $referral_code);
			} else {
				register_user($registration_info);				
			}
			header('Location: register.php?success');
			exit;
		} else if(!empty($errors)){
			//output errors
			echo output_errors($errors);
		}
?>
<h2>Register</h2>
<form action="" method="post">
	<ul>
		<li>
			Username*:<br />
			<input type="text" name="username"/>
		</li>			
		<li>
			Password*:<br />
			<input type="password" name="password"/>
		</li>
		<li>
			First name*:<br />
			<input type="text" name="f_name"/>
		</li>
		<li>
			Last name:<br />
			<input type="text" name="l_name"/>
		</li>
		<li>
			Email*:<br />
			<input type="text" name="email"/>
		</li>
		<li>
			<input type="submit" value="Register" class="button"/>
		</li>
	</ul>
</form>   
<?php
	}
	include_once('includes/overall/overall_footer.php'); 
?>