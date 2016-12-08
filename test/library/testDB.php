<?php
require_once dirname(__FILE__) . "/../../library/DB.php";
require_once dirname(__FILE__) . "/../../config/config.php";
Class TestDB extends PHPUnit_Framework_TestCase
{
	public $DB;

	public function setUp()
	{
	}

	public function testConnection()
	{
		$this->assertTrue(defined("HOSTNAME"));
		$this->assertTrue(defined("DB_USER"));
		$this->assertTrue(defined("DB_PASSWORD"));
		$this->assertTrue(defined("DB_NAME"));
	}

	public function testFetchArray()
	{
		$db = new DB;
		$host="localhost";
		$user="root";
		$pass="";
		$db_name="thankscard";
		$db->db_connect ($host, $user, $pass, $db_name);
		$sql = "SELECT * FROM user ";
		$rs = $db->db_query($sql);
		$user = $db->fetch_array($rs);
		print_r($user);
		echo 123;
	}
}