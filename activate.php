<?php 
include 'includes/core/init.php';
logged_in_user_redirect();
include_once('includes/overall/overall_header.php'); 

if(isset($_GET['success']) && empty($_GET['success'])){
?>
	<h2>You're account is now active and you may now login!</h2>
<?php
}
else if(isset($_GET['c'])){
	$email_code = trim($_GET['c']);
	if(!active($email_code)){
		$errors[] = 'There was a problem activating your account. Please contact the site administrator for assistance.';
	}

	if(!empty($errors)){
	?>
	<h2>Something went wrong...</h2>
	<?php
		echo output_errors($errors);
	} else {
		header('Location: activate.php?success');
		exit();
	}
} else {
	header('Location: index.php');
	exit();
}
include_once('includes/overall/overall_footer.php'); 
?>