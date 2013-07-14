<div class="widget">
    <h2>Hello <?php echo $user_data['f_name']; ?>!</h2>
    <div class="inner">
        <div class="profile">
        <?php
            if(!empty($user_data['profile_pic'])){
                echo '<a href="' . $user_data['user_name'] . '"><img src="' . $user_data['profile_pic'] . '" alt="' . $user_data['f_name'] . '"/></a>';
            } else {           
        ?>
            <a href="settings.php" class="small-link">Add a profile picture.</a>        
        <?php } ?>
        </div>
    	<ul>
            <li>
                <a href= "logout.php">Log out</a>
            </li>   		
            <li>
                <a href= "<?php echo $user_data['user_name']; ?>">Profile</a>
            </li>
            <li>
                <a href= "settings.php">Settings</a>
            </li>
            <li>
                <a href= "change_password.php">Change password</a>
            </li> 
    	</ul>       
    </div>
</div>