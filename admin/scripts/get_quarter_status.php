<?php

require_once('../../global/connect.php');
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$category = mysqli_real_escape_string($conn, $_GET['category']);
if(isset($_GET['page']) AND filter_var($_GET['page'], FILTER_VALIDATE_INT)){
	$page = intval(mysqli_real_escape_string($conn, $_GET['page']));
} else{
	$page = 0;
}

//$records_per_page = 5;
//$total_records = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `quarter_status` WHERE `QStatus` = '$category'")) or die(mysqli_error($conn));
//$offset = ceil($page * $records_per_page);

//$query = "SELECT * FROM `quarter_status` WHERE `QStatus` = '$category' LIMIT $offset, $records_per_page";
$query = "SELECT * FROM `quarter_status` WHERE `QStatus` = '$category'";
$query_result = mysqli_query($conn, $query);

if(mysqli_num_rows($query_result) == 0){
	$response_str = "<h3>No quarters are $category!</h3>";
}
else{
	$response_str = "<table>";
	$response_str .= "<tr><th>Quarter Type</th><th>Quarter Number</th><th>Status</th><th>Options</th></tr>";
	while($row = mysqli_fetch_assoc($query_result)){
		$response_str .= "<tr>";
		$response_str .= "<td>$row[QType]</td>";
		$response_str .= "<td>$row[QNo]</td>";
		$response_str .= "<td>$row[QStatus]</td>";
		$response_str .= "<td><button><a href='scripts/view_allotment_history.php?QType=$row[QType]&QNo=$row[QNo]'>History</a></button></td>";
		$response_str .= "</tr>";
	}
	$response_str .= "</table><br>";
	//$response_str .= "<button type='button' onclick='getQStatusByCategory('$category', int($page+1))'>Next Page</button>";

}

echo $response_str;

?>
