<?php
require_once dirname(__FILE__) . "/../library/DB.php";
require_once dirname(__FILE__) . "/../config/config.php";
session_start();
if(!isset($_SESSION["admin"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();

if (isset($_POST["user_eid"])) {
	$user_eid = $db->db_escape_string($_POST["user_eid"]);
	$user_nick_name = $db->db_escape_string($_POST["user_nick_name"]);
	$user_gwid = $db->db_escape_string($_POST["user_gwid"]);
	$sql = "INSERT INTO user (user_eid, user_nick_name, user_reg_datetime, user_gwid) VALUES ('{$user_eid}', '{$user_nick_name}', NOW(), '{$user_gwid}')";
	$db->db_query($sql);
	header("Location: user.php");
	
}
	
?>
<!DOCTYPE html>
<html>
<body>

<h1>Create new User</h1>

<p></p>

	<form name="create" action="create.php" method="post">
		<p><span>User EID:</span><input type="text" name="user_eid"></p>
		<p><span>Nickname:</span><input type="text" name="user_nick_name"></p>
		<p><span>GWID:</span><input type="text" name="user_gwid"></p>
		<p><input type="submit" value="Create"></p>
	</form>
</body>
</html>
