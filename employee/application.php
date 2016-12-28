<?php
require_once('../global/connect.php');
require_once('../global/functions.php');

session_start();

//Make sure employee is already logged in
if(!isset($_SESSION['emp_pis'])){
	//If not, redirect him to login page
	header("location: login.php");
}

$req_errMsg = "Please fill in the details.";
$emp_refNo = "";
$emp_pis = $_SESSION['emp_pis'];
$emp_name = "Error";
$emp_gender = "Error";
$emp_designation = "Error";
$emp_dept = "Error";
$emp_doj = "Error";

$employee_details = getEmployeeDetails($conn, $emp_pis);

if($employee_details){
	$emp_name = $employee_details['Name'];
	$emp_gender = $employee_details['Gender'];
	$emp_designation = $employee_details['Designation'];
	$emp_dept = $employee_details['DeptName'];
	$emp_doj = $employee_details['DOJ'];
}

//Handling form submission
if(isset($_POST['req_submit'])){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Check if user already submitted an application
		if(hasAppliedAlready($conn, $emp_pis)){
			$req_errMsg = "<p style='color:red;'>Sorry, you cannot apply more than once.</p>";
		}

		else{

			$errors = "";

			//Validation
			if(isset($_POST['emp_salary'])){

				if(!filter_var($_POST['emp_salary'], FILTER_VALIDATE_INT) || $_POST['emp_salary'] < 0){
					$errors = "<p style='color:red;'>Please enter a valid salary.</p>";
				}
				else{
					if(!isset($_POST['grade']) || $_POST['grade'] == null){
						$errors = "<p style='color:red;'>Select Grade.</p>";
					}
					else if(!isset($_POST['emp_residence'])){
						$errors = "<p style='color:red;'>Select residence option.</p>";
					}
					else if(!isset($_POST['quarter_type'])){
						$errors = "<p style='color:red;'>Select quarter type.</p>";
					}
				}
			}
			else{
				$errors = "<p style='color:red;'>Enter Salary</p>";
			}

			$req_errMsg = $errors;

			//If Valid
			if($errors == null){

				$ret = submitApplication($conn, $emp_pis, $_POST['emp_salary'], $_POST['grade'], $_POST['emp_residence'], $_POST['quarter_type']);

				if($ret){
					$req_errMsg = "<p style='color:green;'>Success! Your reference Number is: " . $ret . "</p>";
				}
				else{
					$req_errMsg = "<p style='color:red;'>Failed!</p>";
				}
			}
		}
	}
	else{
		unset($_SESSION['digit']);
		$req_errMsg = "<p style='color:red;'>Invalid captcha</p>";
	}
}
?>
<html>

<head>
  <title>Application Form</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for QUARTER ALLOTMENT" />
  <meta name="keywords" content="CCL, CENTRAL COALFIELDS LIMITED, COAL INDIA, CCL QUARTER ALLOTMENT" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/employee.css" />
  <link rel="icon" href="logo.gif" type="image/gif" sizes="16x16">
  <script type="text/javascript" src="scripts/functions.js"></script>
	<style>
		div#contents .form td{
			width: auto;
		}
	</style>
</head>

<body>

	<?php include_once('../global/header.php');?>

	<div id="navbar">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="../downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a class="active" href="application.php">Make a Request</a></li>
			<li><a href="status.php">Your Status</a></li>
			<li><a href="changepwd.php">Change Password</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>

	<div id="contents">
		<h1>Request for quarter here</h1>
		<form class="form" method="post" action="" style="margin: 20px auto;">
			<table>
				<tr><td colspan="2" align="center"><strong><?php echo $req_errMsg;?></strong></td></tr>
				<tr>
					<td>PIS</td>
					<td><input type="text" class="readonly" name="emp_pis" value="<?php echo $emp_pis;?>" readonly></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><input type="text" class="readonly" name="emp_name" value="<?php echo $emp_name;?>" readonly></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td><input type="text" class="readonly" name="emp_gender" value="<?php echo $emp_gender;?>" readonly></td>
				</tr>
				<tr>
					<td>Designation</td>
					<td><input type="text" class="readonly" name="emp_designation" value="<?php echo $emp_designation;?>" readonly></td>
				</tr>
				<tr>
					<td>Department</td>
					<td><input type="text" class="readonly" name="emp_dept" value="<?php echo $emp_dept;?>" readonly><br/></td>
				</tr>
				<tr>
					<td>Date of Joining</td>
					<td><input type="text" class="readonly" id="myDate" value="<?php echo $emp_doj;?>" name="emp_doj" readonly></td>
				</tr>
				<tr>
					<td>Salary</td>
					<td><input type="text" name="emp_salary" required><br/></td>
				</tr>
				<tr>
					<td>Grade</td>
					<td>
						<select id="grade" name="grade" onchange="showQuarterType(this.value)">
							<option value="">Select</option>
							<option value="E1">E1</option>
							<option value="E2">E2</option>
							<option value="E3">E3</option>
							<option value="E4">E4</option>
							<option value="E5">E5</option>
							<option value="E6">E6</option>
							<option value="E7">E7</option>
							<option value="E8">E8</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Do you have a personal residence in Ranchi?</td>
					<td><input type="radio" name="emp_residence" value="Y" checked>Yes<input type="radio" name="emp_residence" value="N">No</td>
				</tr>
				<tr>
					<td>Type of Quarter Opting For</td>
					<td>
						<select name="quarter_type" id="quarter_type">
							<option value="">Select</option>
						</select>
					</td>
				</tr>
				<tr>
						<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
						<td><input type="text" maxlength="5" name="captcha" value="" required=""></td>
				</tr>
				<tr>
					<td colspan="2" class="buttons" align="center">
						<button class="submit" type="submit" name="req_submit">Submit</button>
						<button class="reset" type="reset">Reset</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<?php include_once('../global/footer.php');?>

</body>

</html>
