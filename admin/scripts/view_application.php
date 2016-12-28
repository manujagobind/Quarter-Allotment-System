<?php

require_once('../../global/connect.php');
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: ../login.php');
}

$response_str = "";

$app_refNo = mysqli_real_escape_string($conn, $_GET['app_ref']);
$emp_pis = "";
$app_refStatus = "";

$query1 = "SELECT * FROM `quarter_request` WHERE `RefNo` = $app_refNo";
$query1_result = mysqli_query($conn, $query1);

if($query1_result){

	$application_details = mysqli_fetch_assoc($query1_result);
	$emp_pis = $application_details['PISNo'];

	$query2 = "SELECT `RefStatus` FROM `application_ref` WHERE `RefNo` = $app_refNo";
	$query2_result = mysqli_query($conn, $query2);
	if($query2_result){
		$query2_fetch = mysqli_fetch_assoc($query2_result);
		$app_refStatus = $query2_fetch['RefStatus'];
	}

	$query3 = "SELECT * FROM `employee`, `department` WHERE `employee`.`DeptNo` = `department`.`DeptNo` AND `PISNo` = $emp_pis";
	$query3_result = mysqli_query($conn, $query3);

	if($query3_result){

		$employee_details = mysqli_fetch_assoc($query3_result);
		$response_str = "<div class='content' style='margin:0;'><table>";
		$response_str .= "<tr><td>Reference Number</td><td>$application_details[RefNo]</td></tr>";
		$response_str .= "<tr><td>PIS Number</td><td>$employee_details[PISNo]</td></tr>";
		$response_str .= "<tr><td>Name</td><td>$employee_details[Name]</td></tr>";
		$response_str .= "<tr><td>Gender</td><td>$employee_details[Gender]</td></tr>";
		$response_str .= "<tr><td>Department</td><td>$employee_details[DeptName]</td></tr>";
		$response_str .= "<tr><td>Designation</td><td>$employee_details[Designation]</td></tr>";
		$response_str .= "<tr><td>Date of Joining</td><td>$employee_details[DOJ]</td></tr>";
		$response_str .= "<tr><td>Salary</td><td>$application_details[Salary]</td></tr>";
		$response_str .= "<tr><td>Employee Grade</td><td>$application_details[Grade]</td></tr>";
		$response_str .= "<tr><td>Residence in Ranchi</td><td>$application_details[Residence]</td></tr>";
		$response_str .= "<tr><td>Quarter Type Opted For</td><td>$application_details[QType]</td></tr>";
		$response_str .= "<tr><td>Status</td><td>$app_refStatus</td></tr>";

		if($app_refStatus == 'Approved' || $app_refStatus == 'Vacated'){

			$query4 = "SELECT * FROM `allotment` WHERE `RefNo` = $app_refNo";
			$query4_result = mysqli_query($conn, $query4);

			if($query4_result){

				$allotment_details = mysqli_fetch_assoc($query4_result);
				$response_str .= "<tr><td>Quarter Alloted</td><td>$allotment_details[QType] $allotment_details[QNo]</td></tr>";
				$response_str .= "<tr><td>Start Date</td><td>$allotment_details[StartDate]</td></tr>";
				$response_str .= "<tr><td>End Date</td><td>$allotment_details[EndDate]</td></tr>";
			}
		}
		$response_str .= "</table></div>";
	}
}
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
				<li><a href="../index.php" class="selected">View Applications</a></li>
				<li><a href="../quarter_status.php">Quarter Status</a></li>
				<li><a href="../manage_quarters.php">Manage Quarters</a></li>
				<li><a href="../annual.php">Annual Reports</a></li>
				<li><a href="../settings.php">Change Password</a></li>
				<li><a href="../logout.php">Logout</a></li>
			</ul>
		</div>

	<div class="content" style="overflow:hidden; ">
		<h2>Detailed Application</h2>
		<?php echo $response_str; ?>
	</div>
</div>

<?php include_once('../../global/footer.php');?>

</body>
</html>
