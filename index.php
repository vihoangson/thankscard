<?php
require_once dirname(__FILE__) . "/library/DB.php";
require_once dirname(__FILE__) . "/config/config.php";
session_start();
$db = new DB();
$db->db_connect();
if(isset($_SESSION["user"])) {
	header("Location: list.php");
}
if(isset($_POST["eid"])) {
	$sql = "SELECT * FROM user WHERE (user_eid = '" . $db->db_escape_string($_POST["eid"]) . "' OR LOWER(user_nick_name) = LOWER('" . $db->db_escape_string($_POST["eid"]) . "')) AND active = 1";
	$rs = $db->db_query($sql);
	$user = $db->fetch_array($rs);
	if(!$user){
		$errors = "EID not exist";
	}else {
		$_SESSION["user"] = $user;
		header("Location: list.php");
	};
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	  	<!-- Compiled and minified CSS -->
	  	<link rel="stylesheet" href="/bower_components/Materialize/dist/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Let browser know website is optimized for mobile-->
	</head>
	<body>
		<div class="container">
			<h1>Thanks Card</h1>

			<p>Please enter your EID</p>
			<?php if(isset($errors)) {
				echo "
				<div class='card-panel red darken-1'>{$errors}</div>
				";
			}?>
			<form name="thanks" action="index.php" method="post">
				<p><input type="text" name="eid" placeholder="Your name"></p>
				<p>
 					<button class="btn waves-effect waves-light" type="submit" name="action">Login
					<i class="material-icons right">send</i>
 					</button>
				</p>
			</form>			
		</div>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script>
			$("input[name='eid']").focus();
		</script>
		<!-- Compiled and minified JavaScript -->
		<script src="/bower_components/Materialize/dist/js/materialize.min.js"></script>
	</body>
</html>
