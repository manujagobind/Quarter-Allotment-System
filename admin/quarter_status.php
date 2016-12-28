<?php

require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: admin_login.php');
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
				<li><a href="quarter_status.php" class="selected">Quarter Status</a></li>
				<li><a href="manage_quarters.php">Manage Quarters</a></li>
				<li><a href="annual.php">Annual Reports</a></li>
				<li><a href="settings.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>

		<div class="content">
			<h2>Summary</h2>
			<form>
				<button type="button" onclick="getBriefQuarterSummary()">Current Status</button> |
				<button type="button" onclick="getQStatusByCategory('Vacant', 0)">Vacant Quarters</button> |
				<button type="button" onclick="getQStatusByCategory('Occupied', 0)">Occupied Quarters</button> |
				<button type="button" onclick="getQStatusByCategory('Damaged', 0)">Damaged Quarters</button>
			</form>

			<h2>Quick Search</h2>
			<form>
				<table>
				<tr>
					<td>
						<select id="QType" onclick="getQuarterNumbers(this.value)">
							<option>Select Quarter Type</option>
							<option value="A">Type A</option>
							<option value="B">Type B</option>
							<option value="C">Type C</option>
						</select>
					</td>
					<td>
						<select id="QNo">
							<option>Select Quarter Number</option>
						</select>
					</td>
					<td><button type="button" onclick="quickStatus()">Search</button>
				</tr>
				</table>
			</form>

			<hr/>
			<div id="dispQStatus">
				<h2>Current Status</h2>
				<h3>Type A</h3>
				  <?php echo getQuarterReport($conn, 'A'); ?>
				<h3>Type B</h3>
				  <?php echo getQuarterReport($conn, 'B'); ?>
				<h3>Type C</h3>
				  <?php echo getQuarterReport($conn, 'C'); ?>
			</div>
		</div>
	</div>
	<?php include_once('../global/footer.php');?>
</body>

</html>
