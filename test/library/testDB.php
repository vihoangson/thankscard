<?php
require_once dirname(__FILE__) . "/../../library/DB.php";
require_once dirname(__FILE__) . "/../../config/config.php";
Class TestDB extends PHPUnit_Framework_TestCase 
{
	public $DB;
	
	public function setUp ()
	{
		$info = array (
			"hostname" 		=> HOSTNAME,
			"db_name"		=> DB_NAME,
			"db_user"		=> DB_USER,
			"db_pass"		=> DB_PASSWORD,
		);
		$con = mysqli_connect($info["hostname"], $info["db_user"], $info["db_pass"], $info["db_name"]);
		//var_dump($con);
		$this->DB = new DB($con);
	}
	
	public function testConnection ()
	{
		
	}
	
	public function testFetchArray ()
	{
			
	}
}
