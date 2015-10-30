<?php
class DB {
	public $connection;
	
	/*
	 * Construction
	 */
	 
	public function __construct ($connection = null)
	{
		if($connection) {
			$this->$connection = $connection;
		}
	}
	
	/*
	 * Get error connection
	 */
	public function db_connect_error ()
	{
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}
	
	/*
	 * Get Connection
	 */
	public function db_connect ($host = null, $user = null, $pass = null, $db_name = null)
	{
		if (!$host) $host = HOSTNAME;
		if (!$user) $user = DB_USER;
		if (!$pass) $pass = DB_PASSWORD;
		if (!$db_name) $db_name = DB_NAME;
		
		$con = mysqli_connect($host, $user, $pass, $db_name);
		
		if (!$con) {
			$this->db_connect_error();
			error_log(mysqli_error());
			return false;
		}
		
		if (!mysqli_select_db($con, $db_name)) {
			$this->db_connect_error();
		
			error_log(mysql_error());
			return false;
		}
		
		if (!mysqli_query($con, "SET NAMES utf8")) {

			$this->db_connect_error();
			error_log(mysql_error());
			return false;
		}
		
		$this->connection = $con;
		
		return true;
	}
	
	// Escape string
	function db_escape_string ($str)
	{
		return mysqli_real_escape_string($this->connection, $str);
	}
	
	// Execute query
	function db_query($sql) {
		$rs = mysqli_query($this->connection, $sql);
		if ($rs === FALSE) {
			print("sql:".$sql."<Br>".mysql_error());
			exit;
		}
		return $rs;
	}

	// Get array
	function fetch_array($rs) {
		return @mysqli_fetch_assoc($rs);
	}


	// 
	function selectrow_array($rs) {
		return mysqli_fetch_row($rs);
	}
	
	// 
	function db_num_rows($rs) {
		return mysqli_num_rows($rs);
	}
	
	// Get last value
	function LastValue() {
		list($last_id) =  $this->selectrow_array($this->db_query("SELECT LAST_INSERT_ID();"));
		return $last_id;
	}

	
	// 
	function fetchAll($rs) {
		$rows = array();
		while ($row = $this->fetch_array($rs)) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	function executeFetchAll($sql) {
		$rs = $this->db_query($sql);
		$rows = array();
		while ($row = $this->fetch_array($rs)) {
			$rows[] = $row;
		}
		return $rows;
	}
}
