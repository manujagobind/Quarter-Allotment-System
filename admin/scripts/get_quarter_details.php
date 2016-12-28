<?php

require_once('../../global/connect.php');
session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$QType = mysqli_real_escape_string($conn, $_GET['QType']);
$QNo = mysqli_real_escape_string($conn, $_GET['QNo']);

$query = "SELECT * FROM `quarter_status` WHERE `QType` = '$QType' AND `QNo` = $QNo";
$query_result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($query_result);

$response_str = "<table>";
$response_str .= "<tr><th>Quarter Type</th><th>Quarter Number</th><th>Status</th><th>Options</th></tr>";
$response_str .= "<tr>";
$response_str .= "<td>$row[QType]</td>";
$response_str .= "<td>$row[QNo]</td>";
$response_str .= "<td>$row[QStatus]</td>";
$response_str .= "<td><button><a href='scripts/view_allotment_history.php?QType=$row[QType]&QNo=$row[QNo]'>History</a></button></td>";
$response_str .= "</tr>";
$response_str .= "</table>";

echo $response_str;

?>
