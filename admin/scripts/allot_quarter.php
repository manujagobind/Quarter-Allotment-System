<?php

require_once('../../global/connect.php');
session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$refNo = mysqli_real_escape_string($conn, $_GET['refNo']);
$QType = mysqli_real_escape_string($conn, $_GET['QType']);
$QNo = mysqli_real_escape_string($conn, $_GET['QNo']);
$response_str = "";

$query1 = "INSERT INTO `allotment` (`RefNo`, `QType`, `QNo`, `StartDate`, `EndDate`) VALUES ($refNo, '$QType', $QNo, CURRENT_DATE, NULL)";
$query1_result = mysqli_query($conn, $query1);

if($query1_result){

	$query2 = "UPDATE `quarter_status` SET `QStatus` = 'Occupied' WHERE `QType` = '$QType' AND `QNo` = $QNo";
	$query2_result = mysqli_query($conn, $query2);

	if($query2_result){

		$query3 = "UPDATE `application_ref` SET `RefStatus` = 'Approved' WHERE `RefNo` = $refNo";
		$query3_result = mysqli_query($conn, $query3) or die(mysqli_error());
		$response_str = "<p style='color:green;'>Alloted</p>";

	}
	else{
		$response_str = "<p style='color:red;'>Error. Rollback needed.</p>";
		//TODO: Rollback?
	}
}

else{
	$response_str = "<p style='color:red;'>Allotment failed!</p>";
}

echo $response_str;
?>
