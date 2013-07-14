<?php
session_start();
error_reporting(E_ALL);

require 'functions/general.php';
require 'functions/Chat.php';

$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);
$user = new User();
$errors = array();

if($user->logged_in()){
	$session_user_id = $_SESSION['user_id'];
	$user_data = $user->user_data($session_user_id, 'user_id', 'user_name', 'f_name', 'l_name', 'email', 'email_code', 'referrals_count', 'a_type', 'profile_pic');
	if(!$user->user_active($user_data['user_name'])){
		session_destroy();
		header('Location: index.php');
		exit();
	} 
	$user->change_user_loggedin_status($session_user_id, 1);
} else {
	echo 'not logged in';
}
?>