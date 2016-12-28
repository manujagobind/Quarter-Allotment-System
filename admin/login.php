<?php

require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();

//Check if admin is logged in
if(isset($_SESSION['admin_id'])){
	header('location: index.php');
}

$admin_loginErr = "Log in to continue";	//Error message

if($_POST){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Checking if entries were filled
		if(isset($_POST['admin_id']) AND isset($_POST['admin_pass'])){

			//Validation
			if(validateEmail($_POST['admin_id'])){

				list($flag, $error) = adminLogin($conn, $_POST['admin_id'], $_POST['admin_pass']);

				if($flag){
					$_SESSION['admin_id'] = $_POST['admin_id'];
					header("location: index.php");
				}
				$admin_loginErr = $error;
			}
			else{
				$admin_loginErr = "<p style='color:red;'>Please enter a valid email id.</p>";
			}
		}
	}
	else{
		unset($_SESSION['digit']);
		$admin_loginErr = "<p style='color:red;'>Incorrect captcha!</p>";
	}
}

?>

<html>

<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="styles/dashboard.css" />
</head>

<body>

	<div id="header">
		<div class="logo"><a href="login.php">Administrator <span>Dashboard</span></a></div>
	</div>

	<div id="container">
		<div class="content" style="margin: auto;">

			<form method="post" action="" style="margin: 100px auto;">
				<table align="center">
					<tr>
						<td colspan="2"><?php echo $admin_loginErr;?></td>
					</tr>

					<tr><td>Admin ID</td><td><input type="text" name="admin_id" required></td><tr>
					<tr><td>Password</td><td><input type="password" name="admin_pass" required></td></tr>


					<tr>
							<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
							<td><input type="text" maxlength="5" name="captcha" value=""></td>
					</tr>

					<tr>
						<td colspan="2">
							<button class="submit" type="admin_login_submit">Submit</button>
							<button class="reset" type="admin_login_reset">Reset</button>
						</td>
					</tr>
				 </table>
			</form>
		</div>
	</div>

	<?php include_once('../global/footer.php');?>
</body>

</html>
