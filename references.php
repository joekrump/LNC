<?php 
include 'includes/core/init.php';
protect_page();
include_once('includes/overall/overall_header.php'); 
?>
<h1>People who have signed up thanks to you!</h1>
<?php
	$referral_info = get_user_referral_signups($user_data['email_code']);
	foreach($referral_info as $info){
		printf("Name: %s %s, Email: %s, Account Type: %s<br />", $info['f_name'], $info['l_name'], $info['email'], $info['type']);
	}
?>   
<?php include_once('includes/overall/overall_footer.php'); ?>