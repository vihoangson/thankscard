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

if (isset($_POST["user_id"])) {
	$uid = $db->db_escape_string($_POST["user_id"]);
	$comment = $db->db_escape_string($_POST["content"]);
	$who = $_SESSION["user"]["user_eid"];
	$sql = "INSERT INTO comment (user_id, comment_content, comment_who_thank, comment_reg_datetime) VALUES ('{$uid}', '{$comment}', '{$who}',NOW())";
	$db->db_query($sql);
	header("Location: list.php");
	
}elseif(!isset($_GET["uid"])) {
	header("Location: list.php");
}else {
	$sql = "SELECT * FROM user WHERE user_id = '" . $db->db_escape_string($_GET["uid"]) . "' AND active = '1'";
	$rs = $db->db_query($sql);
	$user = $db->fetch_array($rs);
	
	$sql = "SELECT * FROM comment WHERE user_id = '" . $db->db_escape_string($_GET["uid"]) . "'" . " AND comment_reg_datetime >= '" . date("Y-01-01 00:00:00") . "'" ." ORDER BY comment_reg_datetime DESC";
	$rs = $db->db_query($sql);
	$comments = $db->fetchAll($rs);
	
	if(!$user) {
		header("Location: list.php");
	}
	if(isset($_GET["img"])){
		$img=$_GET["img"];
	}
}
?><!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<!-- Compiled and minified CSS -->
		<link rel="stylesheet" href="/bower_components/Materialize/dist/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Let browser know website is optimized for mobile-->
		<style>
			ul#_emoticonGallery li {
				float: left;
				list-style: none;
				margin: 5px;
			}
		</style>
	</head>
	<body style="padding:0 40px;">
		<nav class="blue darken-2">
			<div class="nav-wrapper">
				<a href="/" class="brand-logo" style="padding-left:20px;">Thanks card</a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li>Hi! <?php echo $_SESSION["user"]["user_nick_name"] ?></li>
					<li><a href="logout.php">Logout</a></li>

				</ul>
			</div>
		</nav>

		<h1>Do you want Say "Thank" To <?php echo $user["user_nick_name"]?> ?</h1>

		<p>Please let me know why you wanna thank him/her ?</p>
		<p><img src='https://group.cybridge.jp/img/user/user_<?php echo $img ?>.jpg' width='60px'/></p>
			<form name="thanks" action="thanks.php" method="post" id="tform">
				<input type="hidden" name="user_id" value="<?php echo $_GET["uid"] ?>" >

				<ul id="_emoticonGallery" class="emoticonGallery clearfix">
					<?php
					foreach ((array)Emotion::$array_emotion as $key => $value) {
						?><li><img src="<?= $value; ?>" title="Yes" alt="<?= $key; ?>"></li><?php
					}
					 ?>
				</ul>

				<p><textarea name="content" id="content" rows="10" cols="50" style="height:130px;"></textarea></p>
				<p>
					<button class="btn waves-effect waves-light blue darken-2" type="submit" name="action">Thanks!
					<i class="material-icons right">send</i>
					</button>
				</p>
			</form>

			<div>
				<?php
					foreach ($comments as $comment) {
						Emotion::add_emotion($comment['comment_content']);
						echo "<p><span class='comment_date'>{$comment['comment_reg_datetime']}</span>&nbsp&nbsp";
						echo "<span class='comment_content'>{$comment['comment_content']}</span></p>";
					}
				?>
			</div>
		<script>
			var form = document.getElementById("tform");
			form.onsubmit = function() {
				
				var ct = document.getElementById("content");
				var content = "Do you agree with your content?"+"\n"+ct.value;

				if(ct.value.length==0){
					alert("Please enter your comment!");
						return false;
				}
				if(ct.value.length>4){
					var r=confirm(content);
					if (r==true)
						{
						return true;
						}
					else
						{
						return false;
						}
				}
				else{
					//xuất báo lỗi
					alert("The comment is short (min is 4 char), please give me more details, thanks.");
					return false;
				}
			}
		</script>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>

		<script language="Javascript">

			jQuery.fn.extend({
				insertAtCaret: function(myValue) {
					return this.each(function(i) {
						if (document.selection) {
				//For browsers like Internet Explorer
				this.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
				this.focus();
			}
			else if (this.selectionStart || this.selectionStart == '0') {
				//For browsers like Firefox and Webkit based
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var scrollTop = this.scrollTop;
				this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
				this.focus();
				this.selectionStart = startPos + myValue.length;
				this.selectionEnd = startPos + myValue.length;
				this.scrollTop = scrollTop;
			} else {
				this.value += myValue;
				this.focus();
			}
		})
				}
			});
			$("#_emoticonGallery li img").click(function(){
				$("#content").insertAtCaret(" "+$(this).attr("alt")+" ");
			});
		</script>
		<!-- Compiled and minified JavaScript -->
		<script src="/bower_components/Materialize/dist/js/materialize.min.js"></script>
	</body>
</html>
<?php



 ?>