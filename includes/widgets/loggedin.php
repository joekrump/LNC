<div class="widget">
    <h2>Hello <?php echo $user_data['f_name']; ?>!</h2>
    <div class="inner">
        <div class="profile">
            <?php
            //checking file uploads
                if(isset($_FILES['profile_pic'])){
                    if(empty($_FILES['profile_pic']['name'])){
                        echo 'Please choose a file';
                    } else {
                        $allowed_formats = array('jpg', 'jpeg', 'gif', 'png');

                        $file_name = $_FILES['profile_pic']['name'];
                        $file_ext  = explode('.', $file_name);
                        $file_ext = strtolower(end($file_ext)); 
                        $file_temp = $_FILES['profile_pic']['tmp_name'];//Where the file is temporarily stored
                        //TODO: add in file size limit.

                        if(in_array($file_ext, $allowed_formats)){
                            update_profile_image($session_user_id, $file_temp, $file_ext);
                            header('Location' . $current_file);
                        } else {
                            echo "Incorrect file type. You may upload the following formats: \n";
                            echo implode(', ', $allowed);
                        }

                    }                
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="profile_pic"/> <input type="submit"/>
            </form>
            <?php
            } 
            if(!empty($user_data['profile_pic'])){
                echo '<a href="' . $user_data['user_name'] . '"><img src="' . $user_data['profile_pic'] . '" alt="' . $user_data['f_name'] . '"/></a>';
            }
        ?>
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