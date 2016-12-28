<?php

require_once('../../global/connect.php');
require_once('../../global/functions.php');

session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$flag = false;
$response_str = "";
$query = "";

//Lookup for a specific application (key = PIS Number)
if(isset($_GET['emp_pis']) AND validatePIS($_GET['emp_pis'])){
	$flag = true;
	$emp_pis = mysqli_real_escape_string($conn, $_GET['emp_pis']);
	$query = generateApplicationLookupQuery($emp_pis, null, null, null, null);
}
//Lookup for a specific application (key = Reference Number)
else if(isset($_GET['app_refNo']) AND validateReferenceNumber($_GET['app_refNo'])){
	$flag = true;
	$app_refNo = mysqli_real_escape_string($conn, $_GET['app_refNo']);
	$query = generateApplicationLookupQuery(null, $app_refNo, null, null, null);
}
//Lookup for a specific applications by category
else if (isset($_GET['category']) AND validateApplicationStatusCategory($_GET['category'])){
	$flag = true;
	$_GET['category'] = mysqli_real_escape_string($conn, $_GET['category']);
	//If restriction on date of applications
	if(isset($_GET['from']) AND isset($_GET['to']) AND validateDateRange($_GET['from'], $_GET['to'])){
		$_GET['from'] = mysqli_real_escape_string($conn, $_GET['from']);
		$_GET['to'] = mysqli_real_escape_string($conn, $_GET['to']);
		$query = generateApplicationLookupQuery(null, null, $_GET['category'], $_GET['from'], $_GET['to']);
	}
	//No restriction on date of applications
	else{
		$query = generateApplicationLookupQuery(null, null, $_GET['category'], null, null);
	}
}

if($flag){
	$query_result = mysqli_query($conn, $query);

	if(mysqli_num_rows($query_result) == 0){
		$response_str = "<h3>No record found!</h3>";
	}
	else{
		$response_str = listApplications($query_result);
	}
}
else{
	$response_str = "<p style='color:red;'>Invalid lookup operation!</p>";
}

echo $response_str;

?>
