<?php 
include 'includes/core/init.php';
logged_in_user_redirect();
include_once('includes/overall/overall_header.php'); 

if(isset($_GET['success']) && empty($_GET['success'])){
?>
	<h3>You're account is now active and you may now login!</h3>
<?php
}
else if(isset($_GET['c'])){

	$email_code = trim($_GET['c']);

	if(!activate($email_code)){
		$errors[] = 'There was a problem activating your account. Please contact the site administrator for assistance at admin@krumpinator.com';
		//TODO: change to actual domain and proper address.
	}

	if(!empty($errors)){
	?>
		<h2>Something went wrong...</h2>
	<?php
		echo output_errors($errors);
	} else {
		if(isset($_GET['r']) && ($_GET['r'] != $_GET['c'])){
			$referral_code = trim($_GET['r']);
			$new_email_code = trim($_GET['c']);
			credit_account($referral_code); //credits the reference's account.
			store_referral_info($referral_code, $new_email_code);						
		}
		header('Location: activate.php?success');
		exit;		
	}
} else {
	header('Location: index.php');
	exit();
}
include_once('includes/overall/overall_footer.php'); 
?>