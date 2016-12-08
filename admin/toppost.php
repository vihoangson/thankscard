<?php
require_once dirname(__FILE__) . "/../library/DB.php";
require_once dirname(__FILE__) . "/../config/config.php";
session_start();
if(!isset($_SESSION["admin"])) {
	header("Location: index.php");
}
$db = new DB();
$db->db_connect();
$fday = "";
$sort = "";
if ($_GET["year"]) {
	$year = $db->db_escape_string($_GET["year"]);
}
if(isset($_GET["sort"])) {
	switch ($_GET['sort']) {
		case '1':
			$sort .= "ORDER BY thanks ASC";
			break;
		case '2':
			$sort .= "ORDER BY thanks DESC";
			break;
		default:
			$sort .= "ORDER BY thanks DESC";
			break;
	}
}else{
	$sort .= "ORDER BY thanks DESC";
}
$sql = "SELECT *, (SELECT COUNT(*) FROM comment WHERE comment.comment_who_thank = user.user_eid"; 
if ($year) {
	$sql .= " AND YEAR(comment_reg_datetime) = '" . $year . "' ";
}

$sql .=" GROUP BY user_eid) AS thanks
		FROM user WHERE active = 1 " . $sort;
							
$rs = $db->db_query($sql);
$users = $db->fetchAll($rs);
?>

<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<body>

<h1>Lampart Members</h1>

<p>List top post member</p>
[<a href="/admin/toppost.php">ALL</a>] [<a href="?year=2014">2014</a>] [<a href="?year=2015">2015</a>] [<a href="?year=2016">2016</a>]
<table border="1" cellpadding="10">
	<thead>
		<th>EID </th>
		<th>Nick Name </th>
		<th>Total Post Thanks <a href="toppost.php?<?php if ($year){echo "year=".$year."&";} ?>sort=1">▲</a><a href="toppost.php?<?php if ($year){echo "year=".$year."&";} ?>sort=2">▼</a></th>
	</thead>
	<tbody>
		<?php
			foreach ($users as $user) {
				echo "<tr>";
					echo "<td>{$user['user_eid']}</td>";
					echo "<td>{$user['user_nick_name']}</td>";
					echo "<td>";
					echo "";
					if($user['thanks']) {
						echo $user['thanks'];
					}else{
						echo "0";
					}
					echo "</td>";
				echo "</tr>";
			}
		?>
	</tbody>
</table>

</body>
</html>