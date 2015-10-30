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

	if(isset($_GET["startdate"])) {
		$startdate = $db->db_escape_string($_GET["startdate"]);
	}

	if(isset($_GET["enddate"])) {
		$enddate = $db->db_escape_string($_GET["enddate"]);
	}
	
	$sql = "SELECT comment.*, user.user_nick_name AS who_thank 
							FROM comment LEFT JOIN user 
							ON comment.comment_who_thank = user.user_eid 
								WHERE comment.user_id = '" . $db->db_escape_string($_GET["uid"]) . "'";

							if($startdate){
								$sql .= " AND comment_reg_datetime >= '" . $startdate . "'";
							}
							if($enddate){
								$sql .= " AND comment_reg_datetime <= '" . $enddate . "'";
							}
	$sql .= " AND comment_reg_datetime >= '" . date("Y-01-01 00:00:00") . "'";

	$rs = $db->db_query($sql);
	$comments = $db->fetchAll($rs);
	
	if(!$user) {
		header("Location: user.php");
	}
}
	
?>
<!DOCTYPE html>
<html>
<body>

<h1>Thanks for <?php echo $user["user_nick_name"]?></h1>

<p></p>
	
	<div>
		<?php
			foreach ($comments as $comment) {
				echo "<p><span class='comment_date'>{$comment['comment_reg_datetime']}</span>&nbsp|&nbsp";
				echo "<span class='comment_content'>{$comment['comment_content']}</span>&nbsp|&nbsp";
				echo "<span class='comment_content'>{$comment['who_thank']}</span></p>";
			}
		?>
	</div>
</body>
</html>
