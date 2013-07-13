<?php
	/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	 * users.php - Contains functions that deal with users in the system.
	 * @version 1.0
	 * @date 07-03-2013
	 * @author Joseph Krump
	 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

	/********************************************************************
	* store_referral_info - stores info on who signed up thanks to a 
	* specific referral.
	* @param user_id - id of the user you want to get the credits for.
	* @return - The number of credits a user currently has.
	********************************************************************/
	function get_user_referral_signups($referral_code){
		$referral_code = sanitize($referral_code);
		$query = mysql_query("SELECT `f_name`, `l_name`, `email`, `referral_id`, `type`
		 FROM `users` u JOIN `referrals` r
		  ON u.email_code = r.new_email_code
		   WHERE `referral_code` = '$referral_code'
		    ORDER BY `referral_id`");

		$referral_email_codes = array();
		$referral_info = array();

		while ($row = mysql_fetch_assoc($query)) {
    		$referral_info[] = $row; 
		}

		return $referral_info;
	}

	/********************************************************************
	* store_referral_info - stores info on who signed up thanks to a 
	* specific referral.
	* @param user_id - id of the user you want to get the credits for.
	* @return - The number of credits a user currently has.
	********************************************************************/
	function store_referral_info($referral_code, $new_email_code){
		mysql_query("INSERT INTO `referrals` (`referral_code`, `new_email_code`) VALUES ('$referral_code', '$new_email_code')");
	}

	/********************************************************************
	* get_user_credits - retrieve the number of credits a user has. 
	* @param user_id - id of the user you want to get the credits for.
	* @return - The number of credits a user currently has.
	********************************************************************/
	function get_user_credits($user_id){
		$query = mysql_query("SELECT `referrals_count` FROM `users` WHERE `user_id` = '$user_id'");
		return mysql_result($query, 0);
	}

	/********************************************************************
	* activate - Gets data attributes for a user from the database. 
	* @param email_code - a unique code given to a user when they 
	*					   first register.
	* @return - true if the account was successfully activated, otherwise
	*			 returns false. 
	********************************************************************/
	function credit_account($email_code){
		$query = mysql_query("SELECT `referrals_count` FROM `users` WHERE `email_code` = '$email_code'");
		$current_count = mysql_result($query, 0);
		$current_count = $current_count + 1;
		mysql_query("UPDATE `users` SET `referrals_count` = '$current_count' WHERE `email_code` = '$email_code'");
	}

	/********************************************************************
	* activate - Sets a previously 'inactive' user's account to 'active' 
	*            if passed a valid $email_code
	* @param email_code - a unique code given to a user when they 
	*					   first register.
	* @return - true if the account was successfully activated, otherwise
	*			 returns false. 
	********************************************************************/
	function activate($email_code){
		$email_code = mysql_real_escape_string($email_code);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email_code` = '$email_code' AND `active` = 0");

		if(mysql_result($query, 0) == 1){
			mysql_query("UPDATE `users` SET `active` = 1 WHERE `email_code` = '$email_code'");
			return true;
		} else {
			return false;
		}
	}

	/********************************************************************
	* register_user - Registers a user in the database.
	* @param registration_info - an assoc array of data required to 
	*							 register a new user.
	* @param referral_code - a unique referral code associate with 
	*					     the account of the person who referred them.
	*                        NOTE: if user was not referred, set value 
	*                              to zero.
	* @return - returns the values for the user's attributes as 
	*           an associative array. 
	********************************************************************/
	function register_user($registration_info, $referral_code){
		array_walk($registration_info, 'sanitize_array');
		$registration_info['password'] = md5($registration_info['password']);

		$fields = '' . implode(' ,', array_keys($registration_info)) . '';
		$data = '\'' . implode('\',\'', $registration_info) . '\'';

		mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
		if($referral_code != 0){
			//send an email to the new user to activate their account. email function is found in general.php
			email($registration_info['email'], 'Activate your account', "Hello " . $registration_info['f_name'] . 
			",\n\n Follow the link below to activate your account:" . 
			"\nhttp://krumpinator.com/LNC/activate.php?c=". $registration_info['email_code'] . "&r=" . $referral_code . 
			"\n\nGet credit for users who signup through your own personal link: " .
			"\nhttp://krumpinator.com/LNC/register.php?r=" . $registration_info['email_code'] .
			"\n\n- Krumpinator.com"); //TODO: set to an appropriate name.
		} else {
			email($registration_info['email'], 'Activate your account', "Hello " . 
			$registration_info['f_name'] . 
			",\n\nFollow the link below to activate your account:" . 
			"\nhttp://krumpinator.com/LNC/activate.php?c=". $registration_info['email_code'] . 
			"\n\nGet credit for users who signup through your own personal link: \n" . 
			"http://krumpinator.com/LNC/register.php?r=" . $registration_info['email_code'] . 
			"\n\n- Krumpinator.com"); //TODO: set to an appropriate name.
		}
	}

	/********************************************************************
	* user_data - Gets data attributes for a user from the database. 
	* @param user_id - the attributes to be retrieved from the database.
	* @return - returns the values for the user's attributes as 
	*           an associative array. 
	*******************************************************************/
	function user_data($unique_field){
		$data = array();

		$num_args = func_num_args();
		$args = func_get_args();
		
		if($num_args > 1){
			unset($args[0]);

			$fields = '`' . implode('` ,`', $args) . '`';
			//gets all values for attributes given in fields from db. 
			$data = mysql_fetch_assoc(
				mysql_query("SELECT $fields 
					FROM `users` 
					WHERE `user_id` = '$unique_field' 
					OR `email` = '$unique_field'")
			);
			return $data;
		}
	}

	/********************************************************************
	* logged_in - Checks to see if a user is logged in by checking 
	*			   $_SESSION 
	* @return - true if the user is logged in, else false. 
	********************************************************************/
	function logged_in(){
		return (isset($_SESSION['user_id'])) ? true : false;
	}

	/********************************************************************
	* user_exists - Checks to see if a username exists within the 
	*				 database.
	* @param $username - the username that you want to search for. 
	* @return - true if the username is found, else false. 
	********************************************************************/
	function user_exists($username){
		$username = sanitize($username);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username'");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	/********************************************************************
	* email_exists - Checks to see if an email exists within the 
	*				 database.
	* @param $username - the username that you want to search for. 
	* @return - true if the username is found, else false. 
	********************************************************************/
	function email_exists($email){
		$email = sanitize($email);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	/********************************************************************
	* user_active - Checks to see if a user is marked as active.
	* @param $username - the username for the account that is being
	*					  verified as active or not. 
	* @return - true if the user is active, else, false.
	********************************************************************/
	function user_active($username){
		$username = sanitize($username);
		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username' AND `active` = 1");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	/********************************************************************
	* user_id_from_username - gets the user_id for corresponding to the
	*						   username that was given.
	* @param $username - the username corresponding to the user_id desired.
	* @return - true if the user is logged in, else false. 
	********************************************************************/
	function user_id_from_username($username){
		$username = sanitize($username);
		$query = mysql_query("SELECT `user_id` FROM `users` WHERE `user_name` = '$username'");
		return mysql_result($query, 0, 'user_id');
	}

	/********************************************************************
	* login - Tries to log a user in by checking if $password and 
	*		   $username values match a combination in the database. 
	* @param $username - the username given at the login request.
	* @param $password - the password given at the lgoin request. 
	* @return - the user_id for the user if login was succesfull, else 
	*           false.
	********************************************************************/
	function login($username, $password){

		$username = sanitize($username);
		$password = md5($password);

		$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_name` = '$username' AND `password` = '$password'");
		return (mysql_result($query, 0) == 1) ? user_id_from_username($username) : false;
	}

	/********************************************************************
	* get_active_users - Return the number of users in the database 
	*                    that are marked as active 
	* @return - the number of active users.
	********************************************************************/
	function get_active_users(){
		$query = mysql_query("SELECT COUNT(`user_id`) AS users FROM `users` WHERE `active` = 1");
		return mysql_result($query, 0);
	}

	/********************************************************************
	* change_password - Changes the password for a specified user.
	* @param user_id - the id for the user that wants their password 
	*                  changed.
	* @param $password - the new value for the user's password 
	*                    (plain text)
	********************************************************************/
	function change_password($user_id, $password){
		$password = md5($password);
		$user_id = (int)$user_id;

		mysql_query("UPDATE `users` SET password = '$password' WHERE user_id = $user_id");
	}

	/********************************************************************
	* update_data - Updates the database with new information passed.
	* @param update_data - an array of data for attributes which are to 
	*						be updated in the database.
	********************************************************************/
	function update_data($update_data){
		array_walk($update_data, 'sanitize_array');
		$id = $_SESSION['user_id'];
		foreach($update_data as $field => $data){
			$update[] = '`' . $field . '` = \'' . $data . '\'';
		}

		mysql_query("UPDATE `users` SET ". implode(', ', $update) . " WHERE `user_id` = '$id'");
	}

	/********************************************************************
	* recover_info - Sends an email to a user in order for them to
	*				  recover either their username, or password.
	* @param mode - the type of recover this is. (ie. password)
	* @param email - the email that the reovery info is to be sent to.
	********************************************************************/
	function recover_info($mode, $email){
		$mode  = sanitize($mode);
		$email = sanitize($email);

		$user_data = user_data($email, 'user_id', 'f_name', 'user_name');
		$user_id = $user_data['user_id'];
		//send an email for recovering the user's username.
		if($mode == 'username'){
			email($email, 'Krumpinator.com Username Recovery', "Hello " . 
				$user_data['f_name'] . 
				",\n\nYour username is: " . 
				$user_data['user_name'] . "\n\n-Krumpinator.com");
		//send an email for recovering the user's password.
		} else if($mode == 'password'){
			$generated_password = substr(md5(rand(999, 999999)), 0, 8); //generate a new password.
			email($email, 'Krumpinator.com Password Recovery', "Hello " . 
				$user_data['f_name'] . ",\n\nYour new password is: " . 
				$generated_password . 
				"\nWe recommend that once you login you go to \"Change Password\"" . 
				" and update your password to something more memorable.\n\n-Krumpinator.com");
			change_password($user_id, $generated_password);
		}
	}

	/********************************************************************
	* has_access - Checks to see if a user account is of a specified type.
	* @param acct_type - the account type to check against.
	* @return true if the user is an admin, otherwise, returns false.
	********************************************************************/
	function has_access($acct_type){
		global $user_data;
		return ($user_data['a_type'] == $type) ? true : false;
	}
?>