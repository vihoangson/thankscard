<?php
require_once dirname(__FILE__) . "/library/DB.php";
require_once dirname(__FILE__) . "/config/config.php";
require_once dirname(__FILE__) . "/library/emotion.php";
session_start();
if(!isset($_SESSION["user"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();
$fday = "";
$sort = "";
if(!isset($_GET["sort"])) {
	$sort .= "ORDER BY user_eid ASC";
}
if(isset($_GET["sort"])) {
	switch ($_GET['sort']) {
		case '1':
			$sort .= "ORDER BY user_eid ASC";
			break;
		case '2':
			$sort .= "ORDER BY user_eid DESC";
			break;
		case '3':
			$sort .= "ORDER BY user_nick_name ASC";
			break;
		case '4':
			$sort .= "ORDER BY user_nick_name DESC";
			break;
		default:
			$sort .= "ORDER BY user_eid DESC";
			break;
	}
}
$filter = "";
if(isset($_GET["keyword"])) {
	$filter .= "AND (user.user_nick_name LIKE '%" . $db->db_escape_string($_GET["keyword"]) . "%' OR user.user_eid LIKE '%" . $db->db_escape_string($_GET["keyword"]) . "%') ";
}

$sql = "SELECT *, (SELECT COUNT(*) FROM comment 
					WHERE user.user_id = comment.user_id 
						GROUP BY user_id) AS thanks , 
				  (SELECT COUNT(*) FROM comment 
					WHERE user.user_id = comment.user_id AND comment_reg_datetime BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() 
						GROUP BY user_id) AS thank_in_month ,
				  (SELECT comment_content FROM comment
				  	WHERE user.user_id = comment.user_id
				  		ORDER BY comment_reg_datetime DESC LIMIT 1) AS last_comment
							FROM user WHERE active = '1' " . $filter . $sort;
							
$rs = $db->db_query($sql);
$users = $db->fetchAll($rs);

$content = file_get_contents("content.htm");
$regex = "/\/user\/detail\?id=([0-9]+)\">([^<]*?)</";
preg_match_all($regex, $content, $matches);
?>
<!DOCTYPE html>
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
		<nav class=" blue darken-2">
			<div class="nav-wrapper">
				<a href="/" class="brand-logo " style="padding-left:20px;">Thanks card</a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li>Hi! <?php echo $_SESSION["user"]["user_nick_name"] ?></li>
					<li><a href="logout.php">Logout</a></li>

				</ul>
			</div>
		</nav>
		
	<div class="" >
		
		<h1>Lampart Members</h1>

		<form method="get" action="list.php">
			<label>Filter:</label>
			<input type="text" name="keyword" placeholder="Keyword" />
		</form>
		<?php if (!empty($users)) { ?>
		<p><h3>List members</h3></p>
	</div>
		<div class="">

<div style="float:left;width:50%">
<table class="striped bordered">
	<thead>
		<th>EID <a href="list.php?sort=1">▲</a><a href="list.php?sort=2">▼</a></th>
		<th>Image</th>
		<th style="width:140px">Nick Name <a href="list.php?sort=3">▲</a><a href="list.php?sort=4">▼</a></th>
		<th>Last Comment</th>
		<th>Thanks</th>		
	</thead>
	<tbody>

		<?php
			for ($i=0; $i < count($users) ; $i++) {
				if (($i%2)==0) {

					$img = "<img class='img_avatar' src='PATH_IMG{$users[$i]['user_gwid']}.jpg' width='40' height='55' />";
					Emotion::add_emotion($users[$i]['last_comment']);
					echo "<tr>";
						echo "<td>{$users[$i]['user_eid']}</td>";
						echo "<td>$img</td>";
						echo "<td>{$users[$i]['user_nick_name']}</td>";
						echo "<td>{$users[$i]['last_comment']}";
						if($users[$i]['user_id'] == $_SESSION['user']['user_id']) {
							echo "<br><a href='whothank.php'>Persons who was say 'thank' you.<a/>";
						}
						echo "</td>";
						echo "<td>";
						echo "<a href='thanks.php?uid={$users[$i]['user_id']}&img={$users[$i]['user_gwid']}' class='waves-effect waves-light blue darken-2 btn'>Thanks!</a></td>";
					echo "</tr>";
				}
			}
		?>
	</tbody>
</table>
</div>
<div style="border-left: 1px solid #ccc;float: left;width: 48%;margin-left: 5px;padding-left: 5px;">
<table  class="striped bordered" >
	<thead>
		<th>EID <a href="list.php?sort=1">▲</a><a href="list.php?sort=2">▼</a></th>
		<th>Image</th>
		<th style="width:140px">Nick Name <a href="list.php?sort=3">▲</a><a href="list.php?sort=4">▼</a></th>
		<th>Last Comment</th>
		<th>Thanks</th>		
	</thead>
	<tbody>
		<?php
	
			for ($i=0; $i < count($users); $i++) { 
				if (($i%2)==1) {

					$img = "<img class='img_avatar' src='https://group.cybridge.jp/img/user/user_{$users[$i]['user_gwid']}.jpg' width='40' height='55' />";
					Emotion::add_emotion($users[$i]['last_comment']);
					echo "<tr>";
						echo "<td>{$users[$i]['user_eid']}</td>";
						echo "<td>$img</td>";
						echo "<td>{$users[$i]['user_nick_name']}</td>";
						echo "<td>{$users[$i]['last_comment']}";
						if($users[$i]['user_id'] == $_SESSION['user']['user_id']) {
							echo "<br><a href='whothank.php'>Persons who was say 'thank' you.<a/>";
						}
						echo "</td>";
						echo "<td>";
						echo "
							<a href='thanks.php?uid={$users[$i]['user_id']}&img={$users[$i]['user_gwid']}' class='waves-effect waves-light blue darken-2 btn'>Thanks!</a>
						</td>";
					echo "</tr>";
				}
			}
		?>
	</tbody>
</table>
</div>
<?php }else { ?>
	<p>Sorry, No members found!</p>
<?php } ?>	
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
