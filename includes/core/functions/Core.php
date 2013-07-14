<?php

class Core{
	public $db;
	protected $result;
	private $rows;

	public function __construct() {
		$this->db = new mysqli('localhost', 'root', '', 'login');
	}

	public function query($sql){
		$this->result = $this->db->query($sql);
	}

	public function rows(){
		for($i = 1; $i <= $this->db->affected_rows; $i++){
			$this->rows[] = $this->result->fetch_assoc();
		}
		return $this->rows;
	}
}
