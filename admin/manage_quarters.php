<?php

require_once('../global/connect.php');
session_start();

//Make sure admin is loggedin
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
				<li><a href="index.php">View Applications</a></li>
				<li><a href="quarter_status.php">Quarter Status</a></li>
				<li><a href="manage_quarters.php"  class="selected">Manage Quarters</a></li>
				<li><a href="annual.php">Annual Reports</a></li>
				<li><a href="settings.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		<div class="content">
			<h2>Check Details</h2>
			<form>
				<table>
				<tr>
					<td><input type="text" id="emp_pis" placeholder="PIS Number"></td>
					<td><button type="button" onclick="applicationLookup('emp_pis')">Search</button>
					<td><button type="reset">Reset</button>
				</tr>
				</table>
			</form>

			<form>
				<table>
				<tr>
					<td><input type="text" placeholder="Reference Number" id="app_refNo"></td>
					<td><button type="button" onclick="applicationLookup('app_refNo')">Search</button>
					<td><button type="reset">Reset</button>
				</tr>
				</table>
			</form>

			<h2>Allot</h2>
				<form>
				<table>
				<tr>
					<td><input type="text" placeholder="Reference Number" id="allot_refNo"></td>
					<td>
					<select id="allot_QType" onchange="getVacantQuarters(this.value)">
						<option>Select Quarter Type</option>
						<option value="A">Type A</option>
						<option value="B">Type B</option>
						<option value="C">Type C</option>
					</select>
					</td>
					<td>
					<select id="allot_QNo">
							<option>Select Quarter Number</option>
					</select>
					</td>
					<td><button type="button" onclick="allotQuarter()">Allot Quarter</button>
					<td><button type="reset">Reset</button>
				</tr>
				</table>
				</form>

				<h2>Vacate</h2>
					<form>
					<table>
					<tr>
						<td><input type="text" placeholder="Reference Number" id="vacate_refNo"></td>
						<td>
						<select id="vacate_QType" onchange="getOccupiedQuarters(this.value)">
							<option>Select Quarter Type</option>
							<option value="A">Type A</option>
							<option value="B">Type B</option>
							<option value="C">Type C</option>
						</select>
						</td>
						<td>
						<select id="vacate_QNo">
								<option>Select Quarter Number</option>
						</select>
						</td>
						<td><button type="button" onclick="vacateQuarter()">Vacate Quarter</button>
						<td><button type="reset">Reset</button>
					</tr>
					</table>
					</form>

			<hr/>
			<div id="allotmentResult"></div>
			<div id="searchResult"></div>
		</div>
	</div>
	<?php include_once('../global/footer.php');?>
</body>

</html>
