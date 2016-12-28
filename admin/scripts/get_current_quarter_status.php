
<?php
require_once('../../global/connect.php');
require_once('../../global/functions.php');
session_start();

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: login.php');
}

$response_str  = "<h2>Current Status</h2>";
$response_str .= "<h3>Type A</h3>";
$response_str .= getQuarterReport($conn, 'A');
$response_str .= "<h3>Type B</h3>";
$response_str .= getQuarterReport($conn, 'B');
$response_str .= "<h3>Type C</h3>";
$response_str .= getQuarterReport($conn, 'C');

echo $response_str;

?>
