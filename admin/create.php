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
	try{
		$user_eid = $db->db_escape_string($_POST["user_eid"]);
		if($_FILES["user_image"]["tmp_name"]){
			$extention_file = preg_match("/\.([a-z])+$/",$_FILES["user_image"]["name"],$match);
			$file_name = $user_eid.$match[0];
			move_uploaded_file($_FILES["user_image"]["tmp_name"],"../images/".$file_name);
		}else{
			$file_name = "";
		}
		$user_nick_name = $db->db_escape_string($_POST["user_nick_name"]);
		$user_gwid = $db->db_escape_string($_POST["user_gwid"]);
		$sql = "INSERT INTO user (user_eid, user_nick_name, user_reg_datetime, user_gwid,user_img) VALUES ('{$user_eid}', '{$user_nick_name}', NOW(), '{$user_gwid}','{$file_name}')";
		$db->db_query($sql);
	}catch (Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n";
		die;
	}
	header("Location: user.php");
}

?>
<!DOCTYPE html>
<html>
<body>

<h1>Create new User</h1>

<p></p>

	<form name="create" action="create.php" method="post" enctype="multipart/form-data">
		<p><span>User EID:</span><input type="text" name="user_eid"></p>
		<p><span>Nickname:</span><input type="text" name="user_nick_name"></p>
		<p><span>GWID:</span><input type="text" name="user_gwid"></p>
		<p><span>IMG:</span><input type="file" name="user_image"></p>
		<p><input type="submit" value="Create"></p>
	</form>
</body>
</html>
