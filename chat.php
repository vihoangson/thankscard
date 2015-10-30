<?php
require_once dirname(__FILE__) . "/library/DB.php";
require_once dirname(__FILE__) . "/config/config.php";
session_start();
if(!isset($_SESSION["user"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();
//$from = "NOW"
$sql = "SELECT * FROM message INNER JOIN user ON message.message_user = user.user_id WHERE message.message_created <= '" .date("Y-m-d h:i:s"). "' limit 10";
$rs = $db->db_query($sql);
$message = $db->fetchAll($rs);			
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CIBRiDGE ASIA Thanks Card - Member List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="/thankcard/img/icon_fav.ico" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="css/common.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/print.css" media="print">
	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/script.js"></script>
	<style type="text/css">
	.message {
		border: 1px solid #ccc;
		padding: 10px;
	}
	#msglist {
		height: 600px;
		overflow: auto;
		padding: 5px;
		border: 2px solid black;
		float: right;
		width: 88%;
	}
	#group {
		float: left;
		width: 10%;
		border: 2px solid black;
		height: 600px;
		overflow: auto;
	}
	.clear {
		clear: both;
	}
	</style>
</head>
<body id="listPage">
<div id="wrapper" class="clearfix">
<p><button onclick="get_message_list('old')" value="<?php echo $message[0]['message_created']?>" id="mgs_first">GET OLD MESSAGE</button></p>
<br>
<div id="group">
</div>
<div id="msglist">
<?php foreach ($message as $key => $value) {
	echo "<div class='message'>";
	echo "<p>" . $value["user_nick_name"] . ":</p>";
	echo "-----------------";
	echo "<p>" . $value["message_content"] . "</p>";
	echo "-----------------";
	echo "<p>" . $value["message_created"] . "</p>";
	echo "</div>";
	echo "<br/>";
}?>
</div>
<br>
<input type="hidden" value="<?php echo $value['message_created']?>" id="mgs_last"/>
<br>
<br>
<br>
<div class="clear"></div>
<form id="form-msg">
<p>Enter your message</p>
<textarea name="message" id="msg" cols="50" rows="10"></textarea>
<input type="submit" value="submit">
</form>
</div>

<script type="text/javascript">
	//Get message each after 5s 
	setInterval(function(){
		var date = $('#mgs_last').val(); 
		get_message_list(date, 'new');
	},3000);

	$('#form-msg').submit(function(e){
		e.preventDefault();
		var content = $('#msg').val();
		var user_id = <?php echo $_SESSION["user"]["user_id"]; ?>;
		if(content.length <= 0) {
			alert('please enter the message');
		}else {
			$.ajax({
				type: "POST",
				url: "add_msg.php",
				data: "message[user_id]=" +user_id+ "&message[message_content]=" + content,
				cache: false,
				dataType: "text",
				success: function(ret){
					var date = $('#mgs_last').val();
					get_message_list(date, 'new');
					$('#msg').val('');
				}
			});
		}
		return false;
	});

	function get_message_list (date,type)
	{
		$.ajax({
				type: "GET",
				url: "message.php",
				data: "date=" + date + "&type=" + type,
				cache: false,
				dataType: "text",
				success: function(ret){
					data = JSON.parse(ret);
					//console.log(data);
					var last = "";
					data.map(function(message){
						var html = "<div class='message'>";
						html += "<p>" + message.user_nick_name + ":</p>";
						html += "-----------------";
						html += "<p>" + message.message_content + "</p>";
						html +="-----------------";
						html += "<p>" + message.message_created + "</p>";
						html += "</div><br/>";
						$(html).appendTo('#msglist')
						last = message.message_created;
						
					});

					if(last.length > 0) {
						$('#mgs_last').val(last);
						var $t = $('#msglist');
    					$t.animate({"scrollTop": $('#msglist')[0].scrollHeight}, "slow");
					}	
				}
		});
	}

</script>
</body>
</html>