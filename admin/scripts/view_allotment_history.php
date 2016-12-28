<?php

require_once('../../global/connect.php');
require_once('../../global/functions.php');
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$QType = mysqli_real_escape_string($conn, $_GET['QType']);
$QNo = mysqli_real_escape_string($conn, $_GET['QNo']);

$response_str = getAllotmentHistory($conn, $QType, $QNo);

?>
<html>
<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../styles/dashboard.css" />
</head>
<body>

	<div id="header">
		<div class="logo"><a href="../index.php">Administrator <span>Dashboard</span></a></div>
	</div>

	<div id="container">
		<div class="sidebar">
			<ul id="nav">
				<li><a href="../index.php">View Applications</a></li>
				<li><a href="../quarter_status.php" class="selected">Quarter Status</a></li>
				<li><a href="../manage_quarters.php">Manage Quarters</a></li>
				<li><a href="../annual.php">Annual Reports</a></li>
				<li><a href="../settings.php">Change Password</a></li>
				<li><a href="../logout.php">Logout</a></li>
			</ul>
		</div>

	<div class="content" style="overflow:hidden; ">
		<h2>Allotment History for <?php echo $QType; echo $QNo;?></h2>
		<?php echo $response_str; ?>
	</div>
</div>

<?php include_once('../../global/footer.php');?>

</body>
</html>
