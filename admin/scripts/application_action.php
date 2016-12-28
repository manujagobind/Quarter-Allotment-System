<?php

require_once('../../global/connect.php');
session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$_GET['app_ref'] = mysqli_real_escape_string($conn, $_GET['app_ref']);
$_GET['action'] = mysqli_real_escape_string($conn, $_GET['action']);

//Retrieve application reference and action to be performed
$app_ref = intval($_GET['app_ref']);
$action = $_GET['action'];

//Check if application reference was set
if(isset($app_ref)){

	$query = "SELECT * FROM `application_ref` WHERE `RefNo`=$app_ref";
	$query_result = mysqli_query($conn, $query);

	//Check if application reference was valid
	if(mysqli_num_rows($query_result)==1){

		//Reject request and redirect back
		if($action == 'r'){
			$update_query = "UPDATE `application_ref` SET `RefStatus` = 'Rejected' WHERE `RefNo` = $app_ref";
			if(mysqli_query($conn, $update_query)){
				header('location: ../index.php');
			}else{
				die(mysqli_error());
			}
		}
		//Redirect back if unknown action was specified
		else{
			header('location: ../index.php');
		}
	}
	else
		header('location: ../index.php');
}

?>
