<?php

require_once('../global/connect.php');
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: login.php');
}

?>
<html>

<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="styles/dashboard.css" />
	<script type="text/javascript" src="scripts/functions.js"></script>
</head>

<body>

	<div id="header">
		<div class="logo"><a href="index.php">Administrator <span>Dashboard</span></a></div>
	</div>

	<div id="container">
		<div class="sidebar">
			<ul id="nav">
				<li><a href="index.php" class="selected">View Applications</a></li>
				<li><a href="quarter_status.php">Quarter Status</a></li>
				<li><a href="manage_quarters.php">Manage Quarters</a></li>
				<li><a href="annual.php">Annual Reports</a></li>
				<li><a href="settings.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>

		<div class="content">
			<h2><span id="applications_category"></span> Applications<span id="applications_range"></span></h2>

			<div>
				<button type="button" onclick="retrieveApplications('All')">All Requests</button> |
				<button type="button" onclick="retrieveApplications('Pending')">Pending</button> |
				<button type="button" onclick="retrieveApplications('Approved')">Approved</button> |
				<button type="button" onclick="retrieveApplications('Rejected')">Rejected</button>

				<form style="float:right">
					<input type="date" id="range_lb" placeholder="From">
					<input type="date" id="range_ub" placeholder="To">
					<button type="button" onclick="retrieveApplicationsInRange()">Submit</button>
				</form>
			</div>
			<br/><hr/>
			<div id="dispApplications"><br/><p>Select any option from above.</p></div>
		</div>
	</div>
	<?php include_once('../global/footer.php');?>
</body>

</html>
