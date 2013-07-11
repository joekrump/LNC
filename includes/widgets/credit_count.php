<div class="widget">
    <div class="inner">
    	<span class="highlight">
    	<?php
    		$credits = get_user_credits($session_user_id);

    		if($credits == 1){
    			echo "You currently have " . $credits . " credit.";
    		} else {
    			echo "You currenlty have " . $credits . " credits.";
    		}
    	?> 
    	</span>  	
    </div>
</div>