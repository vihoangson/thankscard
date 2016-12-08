<?php
	require_once dirname(__FILE__) . "/library/DB.php";
	require_once dirname(__FILE__) . "/config/config.php";
	session_start();
	if(!isset($_SESSION["user"])) {
		header("Location: index.php");
	}
	$db = new DB();
	$db->db_connect();

	$message_user = $_POST['message']['user_id'];
	$message_content = $_POST['message']['message_content'];

	$sql = "INSERT INTO message(message_user, message_content, message_created) VALUES ('$message_user', '$message_content', NOW())";
	$rs = $db->db_query($sql);
	exit();
?>