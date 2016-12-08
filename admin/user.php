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

if($_GET["startdate"]) {
	$startdate = $db->db_escape_string($_GET["startdate"]);	
}
if($_GET["enddate"]) {
	$enddate = $db->db_escape_string($_GET["enddate"]);	
}

if($_GET["year"]) {
	$year = $db->db_escape_string($_GET["year"]);
}

if(strtotime($enddate) < strtotime($startdate)) {
	$error = "date is not valid!";
}

$param = $_GET;
$uri = "";
foreach ($param as $key => $value) {
	if($uri !== "") {
		$uri .= "&";
	}
	$uri .= $key . "=" . $value;
}

$uris = preg_replace("/(&)?sort=[0-9]?/", "", $uri);

$uris1 .= $uris . "&sort=1";
$uris2 .= $uris . "&sort=2";
$uris3 .= $uris . "&sort=3";
$uris4 .= $uris . "&sort=4";
$uris5 .= $uris . "&sort=5";
$uris6 .= $uris . "&sort=6";
$uris7 .= $uris . "&sort=7";
$uris8 .= $uris . "&sort=8";

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
	case '5':
		$sort .= "ORDER BY thank_in_month ASC";
		break;
	case '6':
		$sort .= "ORDER BY thank_in_month DESC";
		break;
	case '7':
		$sort .= "ORDER BY thanks ASC";
		break;
	case '8':
		$sort .= "ORDER BY thanks DESC";
		break;
	default:
		$sort .= "ORDER BY user_eid ASC";
		break;
}
}
// print_r(date('Y-m-01'));
// if ($startdate && $enddate) {
	
// }

$sql = "SELECT *, (SELECT COUNT(*) FROM comment 
					WHERE user.user_id = comment.user_id";
					if($startdate && !$error){
						$sql .= " AND comment_reg_datetime >= '" . $startdate . "000000'";
					}
					if($enddate && !$error){
						$sql .= " AND comment_reg_datetime <= '" . $enddate . "235959'";
					}

					if($year && !$error){
						$sql .= " AND YEAR(comment_reg_datetime) = '".$year."' ";
						$sql .= " AND comment_reg_datetime >= '" . $year . "-01-01 00:00:00'";
					} else {
						$sql .= " AND comment_reg_datetime >= '" . date("Y-01-01 00:00:00") . "'";
					}


					$sql .= " GROUP BY user_id) AS thanks , 
				  (SELECT COUNT(*) FROM comment 
					WHERE user.user_id = comment.user_id AND comment_reg_datetime BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() 
						GROUP BY user_id) AS thank_in_month ,
				  (SELECT comment_content FROM comment
				  	WHERE user.user_id = comment.user_id 
				  		ORDER BY comment_reg_datetime DESC LIMIT 1) AS last_comment
							FROM user WHERE active = '1' " . $sort;

if($_GET['debug']=='1')
{
	echo $sql;
}

$rs = $db->db_query($sql);
$users = $db->fetchAll($rs);
?>

<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <script>
  $(function() {
    $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>
<body>

<h1>Lampart Members</h1>

<p>List members</p>

<a href='create.php'>Create new member</a> | <a href='toppost.php'>Top member post</a></p>

<?php
if($startdate){
	echo "startdate: ".$startdate."<br>";
}
if($enddate){
	echo "startdate: ".$enddate."<br>";
}
?>

[<a href="?year=2014&debug=1">2014</a>] [<a href="?year=2015&debug=1">2015</a>] <br>


[<a href="/admin/user.php">ALL</a>]
<?php
for($i = 1; $i <= 12; $i++){
	if ($year) {
		echo ' [<a href="/admin/user.php?year='.$year.'&startdate='.$year.substr("0".$i, -2).'01&enddate='.date("Ymt", strtotime($year."-".substr("0".$i, -2)."-01")).'">'.$i.'</a>] ';
	} else {
		echo ' [<a href="/admin/user.php?startdate='.date("Y").substr("0".$i, -2).'01&enddate='.date("Ymt", strtotime(date("Y")."-".substr("0".$i, -2)."-01")).'">'.$i.'</a>] ';
	}
}

if($error) {
	echo "<p style='color:red'>$error</p>";
}
?>
<form method="get">
	<label>From</label><input name="startdate" class="datepicker" value="<?php echo $startdate ?>">
	<label>To</label><input name="enddate" class="datepicker" value="<?php echo $enddate ?>">
	<button type="submit">Search</button>
</form>
<br>
<table border="1" cellpadding="10">
	<thead>
		<th>EID <a href="user.php?<?php echo $uris1 ?>">▲</a><a href="user.php?<?php echo $uris2 ?>">▼</a></th>
		<th>Nick Name <a href="user.php?<?php echo $uris3 ?>">▲</a><a href="user.php?<?php echo $uris4 ?>&sort=4">▼</a></th>
		<th>Last Comment</th>
		<th>Total in this month <a href="user.php?<?php echo $uris5 ?>">▲</a><a href="user.php?<?php echo $uris6 ?>">▼</a></th>
		<th>Total Thanks <a href="user.php?<?php echo $uris7 ?>">▲</a><a href="user.php?<?php echo $uris8 ?>">▼</a></th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php
			foreach ($users as $user) {
				if ($year) {
					$user["thank_in_month"] = 0;
				}
				echo "<tr>";
					echo "<td>{$user['user_eid']}</td>";
					echo "<td>{$user['user_nick_name']}</td>";
					echo "<td>{$user['last_comment']}</td>";
					echo "<td>{$user['thank_in_month']}</td>";
					echo "<td>";
					echo "";
					if($user['thanks']) {
						echo $user['thanks'];
					}else{
						echo "0";
					}
					echo "</td>";
					echo "<td><a href='edit.php?uid={$user['user_id']}'>Edit</a> | <a href='delete.php?uid={$user['user_id']}' onclick=\"return confirm('Are you sure want to delete');\">Delete</a> | <a href='view.php?uid={$user['user_id']}";
					if ($uris) {
						echo "&{$uris}";
					}
					echo "'>View</a></td>";
				echo "</tr>";
			}
		?>
	</tbody>
</table>
</body>
</html>