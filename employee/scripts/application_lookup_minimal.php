<?php

require_once('../../global/connect.php');
require_once('../../global/functions.php');

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

if($flag){
	$query_result = mysqli_query($conn, $query);

	if(mysqli_num_rows($query_result) == 0){
		$response_str = "<h3>No record found!</h3>";
	}
	else{
		$response_str = listApplicationsMinimal($query_result);
	}
}
else{
	$response_str = "<p style='color:red;'>Invalid lookup operation!</p>";
}

echo $response_str;

?>
