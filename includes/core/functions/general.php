<?php
//general.php - contains general use utility funcitons
//@author Joseph Krump

//Redirects users to a page with a message if they try to access a members page while not logged in.
function protect_page(){
	if(!logged_in()){
		header("Location: signup-to-view-this.php");
		exit();
	}
}
//Checks to see if a user is of a_type 1 (admin). If not, redirects them to index.
function protect_admin(){
	if(!has_access(1)){
		header('Location: index.php');
		exit();
	}
}
//Redirects user to index if they try to access a page while logged in that they shouldn't
function logged_in_user_redirect(){
	if(logged_in()){
		header('Location: index.php');
	}
}
//Strips tags and sql injection from an array of strings.
function sanitize_array(&$array){
	$array = htmlentities(strip_tags(mysql_real_escape_string($array)));
}
//Strips tags and sql injection from a single string.
function sanitize($data){
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

//Prints out an array with specific styling.
function output_errors($errors){
	return '<ul class="error-list"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}

//Email function to email users with a preset 'FROM'
function email($to, $subject, $body){
	mail($to, $subject, $body, 'From: do-not-reply@krumpinator.com');
}

?>