<div class="widget">
    <h2>Users</h2>
    <div class="inner">
    	<?php
    		$num_users = get_active_users();

    		if($num_users == 1){
    			echo "We currently have " . $num_users . " registered user.";
    		} else {
    			echo "We currently have " . $num_users . " registered users.";
    		}
    	?>   	
    </div>
</div>