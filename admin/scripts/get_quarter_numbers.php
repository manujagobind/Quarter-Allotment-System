<?php
require_once('../../global/connect.php');
session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}


$type = $_GET['from'] = mysqli_real_escape_string($conn, $_GET['type']);
$response = "";

$query = "SELECT `QNo` FROM `quarter_status` WHERE `Qtype` = '$type'";
$query_result = mysqli_query($conn, $query);

$response .= "<option>Select Quarter Number</option>";
while($row = mysqli_fetch_assoc($query_result)){
	$response .= "<option value='$row[QNo]'>$row[QNo]</option>";
}

echo $response;
?>
