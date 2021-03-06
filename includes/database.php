<?php
require_once(LIB_PATH.DS."config.php");

class MySQLDatabase {

	private $connection;
	public $last_query;

	function __construct() {
		$this->open_connection();
	}

	public function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
		if (!$this->connection) {
			die("Database connection failed! ".mysqli_connect_error());
		}
	}

	public function close_connection() {
		if (isset($this->connection)) { 
			mysqli_close($this->connection);
		}
	}

	public function query($sql) {
		$this->last_query = $sql;
		$result = mysqli_query($this->connection,$sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result) {
		if (!$result) {
			$output = "Database query faled.".mysqli_error($this->connection);
			//$output .="<br>Last SQL query: ".$this->last_query;
			die($output);
		}
	}

	public function escape_value($string) {
		$escaped_string = mysqli_real_escape_string($this->connection, $string);
		return $escaped_string;
	}

	public function fetch_array($result_set) {
		return mysqli_fetch_assoc($result_set);
	}

	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}

	public function insert_id() {
		return mysqli_insert_id($this->connection);
	}

	public function affected_rows() {
		return mysqli_affected_rows($this->connection);
	}


}

$database = new MySQLDatabase();
$db =& $database;


?>