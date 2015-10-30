<?php
require_once dirname(__FILE__) . "/../library/DB.php";
require_once dirname(__FILE__) . "/../config/config.php";
session_start();
if(!isset($_SESSION["admin"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();

if(!isset($_GET["uid"])) {
	header("Location: user.php");
}else {
	$sql = "SELECT * FROM user WHERE user_id = '" . $db->db_escape_string($_GET["uid"]) . "'";
	$rs = $db->db_query($sql);
	$user = $db->fetch_array($rs);
	
	if($user) {
		$sql = "UPDATE user
						SET active='0'
						WHERE user_id = '" . $db->db_escape_string($_GET["uid"]) . "'";
		$db->db_query($sql);
	}

	header("Location: user.php");

}