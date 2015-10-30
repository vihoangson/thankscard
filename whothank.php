<?php
require_once dirname(__FILE__) . "/library/DB.php";
require_once dirname(__FILE__). "/config/config.php";
require_once dirname(__FILE__) . "/library/emotion.php";
session_start();
if(!isset($_SESSION["user"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();

$sql = "SELECT comment.*, user.user_nick_name AS who_thank 
							FROM comment LEFT JOIN user 
							ON comment.comment_who_thank = user.user_eid 
								WHERE comment.user_id = '" . $_SESSION["user"]["user_id"] . "'";
								$sql .= " AND comment_reg_datetime >= '" . date("Y-01-01 00:00:00") . "'";
$rs = $db->db_query($sql);
$comments = $db->fetchAll($rs);
	
?><!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	  	<!-- Compiled and minified CSS -->
	  	<link rel="stylesheet" href="/bower_components/Materialize/dist/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Let browser know website is optimized for mobile-->
		<style>
		.img_avatar{
			border-radius: 100%;
		}
		</style>
	</head>
	<body style="padding:0 40px;">
		<nav class="blue darken-2 ">
			<div class="nav-wrapper">
				<a href="/" class="brand-logo " style="padding-left:20px;">Thanks card</a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li>Hi! <?php echo $_SESSION["user"]["user_nick_name"] ?></li>
					<li><a href="logout.php">Logout</a></li>

				</ul>
			</div>
		</nav>
		
		<div class="" >
		<h2>Comments</h2>
		<h3>Persons who was say "thank" you.</h3>

		<?php
			foreach ($comments as $comment) {
				Emotion::add_emotion($comment['comment_content']);
				echo "<p><span class='comment_date'>{$comment['comment_reg_datetime']}</span>&nbsp|&nbsp";
				echo "<span class='comment_content'>{$comment['comment_content']}</span>&nbsp|&nbsp";
				echo "<span class='comment_content'>{$comment['who_thank']}</span></p>";
			}
		?>		
		</div>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script>
			$("input[name='keyword']").focus();
		</script>
		<!-- Compiled and minified JavaScript -->
		<script src="/bower_components/Materialize/dist/js/materialize.min.js"></script>
	</body>
</html>
