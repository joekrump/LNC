<?php
//contains general use utility funcitons
//@author Joseph Krump

function protect_page(){
	if(!logged_in()){
		header("Location: signup-to-view-this.php");
		exit();
	}
}

function protect_admin(){
	if(!is_admin()){
		header('Location: index.php');
		exit();
	}
}

function logged_in_user_redirect(){
	if(logged_in()){
		header('Location: index.php');
	}
}

function sanitize_array(&$array){
	$array = htmlentities(strip_tags(mysql_real_escape_string($array)));
}

function sanitize($data){
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

function output_errors($errors){
	return '<ul class="error-list"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}


function email($to, $subject, $body){
	mail($to, $subject, $body, 'From: donotreply@krumpinator.com');
}

?>