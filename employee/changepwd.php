<?php
require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Make sure employee is already logged in
if(!isset($_SESSION['emp_pis'])){
	//If not, redirect him to login page
	header("location: login.php");
}

$emp_settingsMsg = "Update Password";

if($_POST){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Checking if details were filled
		if(isset($_POST['newpass1']) AND isset($_POST['newpass2'])){

			//Validation
			if(validatePassword($_POST['newpass1']) AND validatePassword($_POST['newpass2'])){

				list($flag, $error) = updateEmpPassword($conn, $_SESSION['emp_pis'], $_POST['newpass1'], $_POST['newpass2']);
				$emp_settingsMsg = $error;
			}
			else{
				$emp_settingsMsg = "<p style='color:red;'>Passwords should be 8-20 characters in length.</p>";
			}
		}
		else{
			$emp_settingsMsg = "<p style='color:red;'>All fields are required.</p>";
		}
	}
	else {
		$emp_settingsMsg = "<p style='color:red;'>Invalid captcha!</p>";
	}
}
?>
<html>

<head>
  <title>Change Password</title>
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
			<li><a href="index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="../downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a href="application.php">Make a Request</a></li>
			<li><a href="status.php">Your Status</a></li>
			<li><a class="active" href="changepwd.php">Change Password</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>

	</div>

	<div id="contents">
		<form class="form" method="post" action="">
			<table>
				<tr>
					<td colspan="2" align="center"><strong><?php echo $emp_settingsMsg;?></strong></td>
				</tr>
				<tr>
					<td>New Password</td>
					<td><input type="password" name="newpass1" required></td>
				</tr>
				<tr>
					<td>Re-enter New Password</td>
					<td><input type="password" name="newpass2" required></td>
				</tr>
				<tr>
						<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
						<td><input type="text" maxlength="5" name="captcha" value="" required></td>
				</tr>
				<tr>
					<td colspan="2" class="buttons" align="center">
						<button class="submit" type="submit" name="submit">Submit</button>
						<button class="reset" type="reset">Reset</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<?php include_once('../global/footer.php');?>
</body>

</html>
