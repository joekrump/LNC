<?php
class Chat extends Core {
	public function fetchMessage(){
		//query db
		$this->query("SELECT `message`.`user_id`,
							 `users`.`user_name`,
							 `message`.`message`,
						FROM `message` m JOIN `users` u
						ON   m.user_id = u.user_id
						ORDER BY `chat`.`timestamp`
			");
		return $this->rows();
	}
	public function throwMessage($user_id, $message){
		//insert into db.
	}
}
$today = date("Y-m-d H:i:s", time());
echo $today;

?>