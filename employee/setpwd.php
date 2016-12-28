<?php

require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Check if employee is already logged in
if(isset($_SESSION['emp_pis'])){
	header('location: emp_request.php');
}

//Allow only if employee submitted registration form
if(!isset($_SESSION['temporary_pis'])){
	header('location: register.php');
}

$emp_setpwdErr = "Set your password to continue.";	//Error message
$emp_pis  = $_SESSION['temporary_pis'];

if($_POST){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//If employee started registration procedure
		if(isset($_SESSION['emp_status']) AND $_SESSION['emp_status'] == 0){

			if(isset($_POST['setpass1']) AND isset($_POST['setpass2'])){

				//Validation
				if(validatePassword($_POST['setpass1']) AND validatePassword($_POST['setpass2'])){

					list($flag, $error) = updateEmpPassword($conn, $_SESSION['temporary_pis'], $_POST['setpass1'], $_POST['setpass2']);
					if($flag){
						$_SESSION['emp_status'] = 1; //Specifying that registration procedure has completed
						unset($_SESSION['temporary_pis']);
						header('location: login.php');
					}
					$emp_setpwdErr = $error;
				}
				else{
					$emp_setpwdErr = "<p style='color:red;'>Passwords should be 8-20 characters in length.</p>";
				}
			}
			else{
				$emp_setpwdErr = "<p style='color:red'>All fields are required.</p>";
			}
		}
		//Otherwise, redirect him to home page
		else{
			header('location: ../index.php');
		}
	}
	else{
		unset($_SESSION['digit']);
		$emp_setpwdErr = "<p style='color:red;'Incorrect captcha.</p>";
	}
}

?>
<html>

<head>
  <title>Set Password</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for quarter allotment" />
  <meta name="keywords" content="CCL Ranchi, Central Coalfields Limited, CCL Quarter Allotment" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/employee.css" />
  <link rel="icon" href="../images/logo.gif" type="image/gif">
</head>

<body>

	<?php include_once('../global/header.php');?>

	<div id="contents">

		<h3>Please set you account password to proceed.</h3>

		<form class="form" method="post" action="">
			<table>
				<tr>
					<td colspan="2" align="center"><strong><?php echo $emp_setpwdErr;?></strong></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="setpass1" required></td>
				</tr>
				<tr>
					<td>Re-enter Password</td>
					<td><input type="password" name="setpass2" required></td>
				</tr>
				<tr>
						<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
						<td><input type="text" maxlength="5" name="captcha" value=""></td>
				</tr>
				<tr>
					<td colspan="2" class="buttons" align="center">
						<button class="submit" type="submit" name="setpass_submit">Submit</button>
						<button class="reset" type="reset">Reset</button>
					</td>
				</tr>
			</table>
		</form>

	</div>

	<?php include_once('../global/footer.php'); ?>

</body>

</html>
