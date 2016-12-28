<?php
require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Make sure employee is already logged in
if(!isset($_SESSION['emp_pis'])){
	//If not, redirect him to login page
	header("location: login.php");
}

$emp_pis = $_SESSION['emp_pis'];
$application_status = getApplicationStatus($conn, $emp_pis);
?>
<html>

<head>
  <title>Application Status</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for QUARTER ALLOTMENT" />
  <meta name="keywords" content="CCL, CENTRAL COALFIELDS LIMITED, COAL INDIA, CCL QUARTER ALLOTMENT" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/employee.css" />
  <link rel="icon" href="logo.gif" type="image/gif" sizes="16x16">

</head>

<body>

	<?php include_once('../global/header.php'); ?>

	<div id="navbar">

		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="../downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a href="application.php">Make a Request</a></li>
			<li><a class="active" href="status.php">Your Status</a></li>
			<li><a href="changepwd.php">Change Password</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>

	</div>

	<div id="contents">

		<h1>Your application status</h1>
		<?php echo $application_status;?>

	</div>

	<?php include_once('../global/footer.php');?>

</body>

</html>
