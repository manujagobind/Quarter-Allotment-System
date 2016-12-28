<?php

require_once('../../global/connect.php');
require_once('../../global/functions.php');

session_start();

//Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: index.php');
}

$year = intval(mysqli_real_escape_string($conn, $_GET['year']));

$query1 = "SELECT * FROM `quarter_request` JOIN `application_ref` ON `application_ref`.`RefNo` = `quarter_request`.`RefNo` WHERE YEAR(`ReqDate`) = $year";
$query1_result = mysqli_query($conn, $query1) or die(mysqli_error($conn));

$query2 = "SELECT * FROM `allotment` WHERE YEAR(`StartDate`) = $year";
$query2_result = mysqli_query($conn, $query2) or die(mysqli_error($conn));

$total_num_app = mysqli_num_rows($query1_result);
$total_num_alloted = mysqli_num_rows($query2_result);

$response_str = "<p>Total number of applications: $total_num_app </p>";
$response_str .= "<p>Total quarters alloted: $total_num_alloted </p>";

echo $response_str;

?>
