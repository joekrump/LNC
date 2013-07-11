<?php
session_start();
//error_reporting(0);

require 'database/connect.php';
require 'functions/users.php';
require 'functions/general.php';

$errors = array();

if(logged_in()){
	$session_user_id = $_SESSION['user_id'];
	$user_data = user_data($session_user_id, 'user_id', 'user_name', 'password', 'f_name', 'l_name', 'email', 'email_code', 'referrals_count');
	if(!user_active($user_data['user_name'])){
		session_destroy();
		header('Location: index.php' );
		exit();
	}
}

?>