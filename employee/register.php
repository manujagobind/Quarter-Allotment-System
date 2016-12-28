<?php

require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();
$emp_registerErr = "<p>Register Here</p>";	//Error message

if($_POST){
	//Verify Captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Check if employee is already logged in
		if(isset($_SESSION['emp_pis'])){
			header('location: index.php');
		}

		//Checking if entries were filled
		if(isset($_POST['emp_pis']) AND isset($_POST['emp_pan'])){

			//Validation
			if(validatePIS($_POST['emp_pis'])){

				list($flag, $error) = employeeRegister($conn, $_POST['emp_pis'], $_POST['emp_pan']);
				if($flag){
					//If matches, force him to set password
					$_SESSION['temporary_pis'] = $_POST['emp_pis'];
					$_SESSION['emp_status'] = 0;	//Logged in for the first time
					header("location: setpwd.php");
				}
				$emp_registerErr = $error;
			}
			else{
				$emp_registerErr = "<p style:'color:red;'>Please enter a valid 8 digit PIS Number.</p>";
			}
		}
	}
	else{
		session_destroy();
		$emp_registerErr = "<p style='color:red;'>Incorrect captcha!</p>";
	}
}

?>
<html>

<head>
  <title>Register</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for quarter allotment" />
  <meta name="keywords" content="CCL Ranchi, Central Coalfields Limited, CCL Quarter Allotment" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/employee.css" />
  <link rel="icon" href="../images/logo.gif" type="image/gif" sizes="16x16">

</head>

<body>

	<?php include_once('../global/header.php');?>

	<div id="navbar">

		<ul>
			<li><a href="../index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="../downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a class="active" href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
			<li><a href="status_external.php">Check Status</a></li>
		</ul>

	</div>

	<div id="contents">

		<form class="form" method="post" action="">
			<table>
				<tr>
					<td colspan="2" align="center"><strong><?php echo $emp_registerErr;?></strong></td>
				</tr>
				<tr>
					<td>PIS Number</td>
					<td><input type="text" name="emp_pis" required></td>
				</tr>
				<tr>
					<td>PAN Number</td>
					<td><input type="password" name="emp_pan" required></td>
				</tr>
				<tr>
						<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
						<td><input type="text" maxlength="5" name="captcha" value=""></td>
				</tr>
				<tr>
					<td colspan="2" class="buttons" align="center">
						<button class="submit" type="submit" name="emp_register">Submit</button>
						<button class="reset" type="reset">Reset</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<?php include_once('../global/footer.php');?>

</body>

</html>
