<div class="widget">
    <h2>Hello, <?php echo $user_data['f_name']; ?>!</h2>
    <div class="inner">
    	<ul>
    		<li>
    			<a href= "change_password.php">Change password</a>
    		</li>
    		<li>
    			<a href= "logout.php">Log out</a>
    		</li>
            <li>
                <a href= "<?php echo $user_data['user_name']; ?>">Profile</a>
            </li>
            <li>
                <a href= "settings.php">Settings</a>
            </li>
    	</ul>
    </div>
</div>