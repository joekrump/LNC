<?php
class Chat extends Core {
	public function fetchMessages(){
		//query db
		$this->query("SELECT 
			u.user_name,
			m.user_id, 
			m.message 
			FROM `message` m 
			JOIN `users` u ON m.user_id = u.user_id 
			ORDER BY m.timestamp"
		);

		/*
		if ($this->db->error) {
   			printf("Errormessage: %s\n", $this->db->error);
		}*/
		return $this->rows();
	}

	public function throwMessage($user_id, $message){
		//insert into db.
		$now = date("Y-m-d H:i:s", time());
		$user_id = (int)$user_id;
		$message = sanitize($message);

		$this->query(
			"INSERT INTO 
			`message` 
			(`user_id`, 
			`message`, 
			`timestamp`) 
		VALUES ($user_id, '$message', '$now')
		");
		if ($this->db->error) {
   			printf("Errormessage: %s\n", $this->db->error);
		}
	}
}

?>