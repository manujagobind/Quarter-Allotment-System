<?php
require_once('../global/connect.php');
require_once('../global/functions.php');

session_start();

//Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: index.php');
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
				<li><a href="index.php">View Applications</a></li>
				<li><a href="quarter_status.php">Quarter Status</a></li>
				<li><a href="manage_quarters.php">Manage Quarters</a></li>
        <li><a href="annual.php" class="selected" >Annual Reports</a></li>
				<li><a href="settings.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>

		<div class="content">
      <h2>Annual Report</h2>
			<form>
				<select id="year" name="year" onchange="getAnnualReport(this.value)">
					<option>Select year</option>
					<option value="2016">2016</option>
				</select>
			</form>

			<div id="dispAnnualReport"></div>

    </div>
	</div>
	<?php include_once('../global/footer.php');?>
</body>

</html>
