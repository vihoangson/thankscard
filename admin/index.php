<?php
require_once dirname(__FILE__) . "/../library/DB.php";
require_once dirname(__FILE__) . "/../config/config.php";
session_start();
$db = new DB();
$db->db_connect();

if(isset($_SESSION["admin"])) {
	header("Location: user.php");
}

if(isset($_POST["login_id"])) {
	$errors = array();
	if($_POST["login_id"] == "") {
		$errors[] = "please enter login id";
	}
	if($_POST["password"] == "") {
		$errors[] = "please enter password";
	}
	$pw = 	md5($_POST["password"]);
	$sql = "SELECT * FROM admin WHERE admin_login = '" . $db->db_escape_string($_POST["login_id"]) . 
										"' AND admin_password = '" . $pw . "'";
	$rs = $db->db_query($sql);
	$admin = $db->fetch_array($rs);
	print_r($admin);
	if(!$admin){
		$errors[] = "login id or password is incorrect!";
	}else {
		$_SESSION["admin"] = $admin;
		header("Location: user.php");
	};
}
 
?>

<!DOCTYPE html>
<html>
<body>

<h1>Thanks Card</h1>

<p>Please enter login id</p>
<?php if(isset($errors)) {
	foreach ($errors as $error) {
		echo "<p>{$error}</p>";
	}
}?>
	<form name="thanks" action="index.php" method="post">
		<p><input type="text" name="login_id"></p>
		<p><input type="password" name="password"></p>
		<p><input type="submit" value="Login"></p>
	</form>
</body>
</html>