<?php 
	include 'includes/core/init.php';
	protect_page();
	include_once('includes/overall/overall_header.php'); 

	if(!empty($_POST)){

		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'A valid email address is required';
		}
		if($user->email_exists($_POST['email']) && ($_POST['email'] != $user_data['email'])){
			$errors[] = 'This email address is already in use';
		}
		if(strlen($_POST['f_name']) > 32){
			$errors[] = 'You first name can be a maximum of 32 characters.';
		}
		if(strlen($_POST['l_name']) > 32){
			$errors[] = 'You last name can be a maximum of 32 characters.';
		}
	}
?>
<h1>Settings</h1> 
<?php 
if(isset($_GET['success'])){
	echo 'Your details have been updated!';
} else {
	if(!empty($_POST) && empty($errors) && (($_POST['f_name'] != $user_data['f_name']) || ($_POST['l_name'] != $user_data['l_name']) || ($_POST['email'] != $user_data['email']))){
		$update_data = array(
			'f_name' => $_POST['f_name'],
			'l_name' => $_POST['l_name'],
			'email' => $_POST['email']
		);

		$user->update_data($update_data);
		header('Location: settings.php?success');
		exit();

	} else if (!empty($errors)){
		echo output_errors($errors);
	}
		if(isset($_FILES['profile_pic'])){
	       $allowed_formats = array('jpg', 'jpeg', 'gif', 'png');

	       $file_name = $_FILES['profile_pic']['name'];
	       $file_ext  = explode('.', $file_name);
	       $file_ext = strtolower(end($file_ext)); 
	       $file_temp = $_FILES['profile_pic']['tmp_name'];//Where the file is temporarily stored
	       //TODO: add in file size limit.
	       
	       if(in_array($file_ext, $allowed_formats)){
	           $user->update_profile_image($session_user_id, $file_temp, $file_ext);
	           header('Location:' . $current_file);
	       } else {
	           echo "<p class=\"error-list\">Incorrect file type. You may upload the following formats:</p> \n";
	           echo "<p class=\"error-list\">" . implode(', ', $allowed_formats) . "</p>";
	       }  
	       if(empty($_FILES['profile_pic']['name'])){
	           echo 'Please choose a file';
	       }           
	   } 			    	              
	?>
	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<?php 
				if(!empty($user_data['profile_pic'] )){
					echo '<img src="' . $user_data['profile_pic'] . '" alt="' . $user_data['f_name'] . '" class="thumbnail"/><br />Change Profile Picture:';
				} else {
					echo 'Add a profile picture:';
				}
				?>			
				<br />
				<input type="file" name="profile_pic"/>
			</li>
			<li>
				First name:<br/>
				<input type="text" name="f_name" value="<?php echo $user_data['f_name']; ?>" autofocus/>
			</li>
			<li>
				Last name:<br />
				<input type="text" name="l_name" value="<?php echo $user_data['l_name']; ?>" autofocus/>
			</li>
			<li>
				Email:<br />
				<input type="text" name="email" value="<?php echo $user_data['email']; ?>" autofocus/>
			</li>

			<li>
				<input class="button" type="submit" value="Update"/>
			</li>
		</ul>
	</form>
	
<?php 
}
include_once('includes/overall/overall_footer.php'); 
?>