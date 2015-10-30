<?php
require_once dirname(__FILE__) . "/library/DB.php";
require_once dirname(__FILE__) . "/config/config.php";
session_start();
if(!isset($_SESSION["user"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();

$date = $_GET['date'];
$type = $_GET['type'];
if($type == "new") {
	$where = "message.message_created > '$date'";
}else {
	$where = "message.message_created < '$date'";
}


$sql = "SELECT message.*, user.user_id, user.user_nick_name FROM message INNER JOIN user ON message.message_user = user.user_id";
if($where) {
	$sql .= " WHERE " . $where;
}
$sql .= "limit 10";
$rs = $db->db_query($sql);
$message = $db->fetchAll($rs);
$json = json_encode($message);
echo $json;
exit();		
?>