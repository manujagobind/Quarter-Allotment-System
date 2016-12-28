<?php
require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Check if employee is already logged in
if(isset($_SESSION['emp_pis'])){
	header('location: index.php');
}

$emp_loginErr = "Log in to continue";	//Error message

if($_POST){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Checking if entries were filled
		if(isset($_POST['emp_pis']) AND isset($_POST['emp_pass'])){

			//PIS validation
			if(validatePIS($_POST['emp_pis'])){

				list($flag, $error) = employeeLogin($conn, $_POST['emp_pis'], $_POST['emp_pass']);

				if($flag){
					$_SESSION['emp_pis'] = $_POST['emp_pis'];
					$_SESSION['emp_status'] = 1;
					header("location: index.php");
				}
				else{
					$emp_loginErr = $error;
				}
			}
			else{
				$emp_loginErr = "Please enter a valid 8 digit PIS Number.";
			}
		}
	}
	else{
		$emp_loginErr = "<p style='clas:red;'>Invalid captcha!</p>";
	}
}
?>
<html>

<head>
  <title>Login</title>
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
			<li><a href="register.php">Register</a></li>
			<li><a class="active" href="login.php">Login</a></li>
			<li><a href="status_external.php">Check Status</a></li>
		</ul>

	</div>

	<div id="contents">

		<form class="form" method="post" action="">
			<table>
				<tr>
					<td colspan="2" align="center"><strong><?php echo $emp_loginErr;?></strong></td>
				</tr>
				<tr>
					<td>PIS Number</td>
					<td><input type="text" name="emp_pis" required></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="emp_pass" required></td>
				</tr>
				<tr>
						<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
						<td><input type="text" maxlength="5" name="captcha" value=""></td>
				</tr>
				<tr>
					<td colspan="2" class="buttons" align="center">
						<button class="submit" type="submit">Submit</button>
						<button class="reset" type="reset">Reset</button>
					</td>
				</tr>
			</table>
		</form>

	</div>

	<?php include_once('../global/footer.php');?>

</body>

</html>
