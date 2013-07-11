
<aside id="right_widget">
    <?php
    if(logged_in()){
    	include('includes/widgets/loggedin.php');
    	if($user_data['referrals_count'] > 0){
    		include('includes/widgets/credit_count.php');
    	}
    } else {
	    include('includes/widgets/login.php');
	}
	include 'includes/widgets/user_count.php'
    ?>
</aside>