<?php

require_once('../global/connect.php');
require_once('../global/functions.php');
session_start();
$admin_settingsMsg = "Update Password";

//Make sure admin is loggedin
if(!isset($_SESSION['admin_id'])){
	header('location: login.php');
}

if($_POST){
	//Verify captcha
	if(verifyCaptcha($_POST['captcha'])){
		//Checking if details were filled
		if(isset($_POST['admin_newpass1']) AND isset($_POST['admin_newpass2'])){

			//Validation
			if(validatePassword($_POST['admin_newpass1']) AND validatePassword($_POST['admin_newpass2'])){

				list($flag, $error) = updateAdminPassword($conn, $_SESSION['admin_id'], $_POST['admin_newpass1'], $_POST['admin_newpass2']);
				$admin_settingsMsg = $error;
			}
			else{
				$admin_settingsMsg = "<p style='color:red;'>Passwords should be 8-20 characters in length.</p>";
			}
		}
		else{
			$admin_settingsMsg = "<p style='color:red;'>All fields are required.</p>";
		}
	}
	else{
		$admin_settingsMsg = "<p style='color:red;'>Incorrect captcha!</p>";
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
		<div class="logo"><a href="index.php">Administrator <span>Dashboard</span></a></div>
	</div>

	<div id="container">
		<div class="sidebar">
			<ul id="nav">
				<li><a href="index.php">View Applications</a></li>
				<li><a href="quarter_status.php">Quarter Status</a></li>
				<li><a href="manage_quarters.php" >Manage Quarters</a></li>
				<li><a href="annual.php">Annual Reports</a></li>
				<li><a href="settings.php" class="selected">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>

		<div class="content">
			<h2>Profile Settings</h2>

			<form method="post" action="">
				<table>
					<tr>
						<td colspan="2"><?php echo $admin_settingsMsg;?></td>
					</tr>

					<tr><td>New Password</td><td><input type="password" name="admin_newpass1" required></td><tr>
					<tr><td>Re-type Password</td><td><input type="password" name="admin_newpass2" required></td></tr>

					<tr>
							<td>Captcha <image src="../global/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></td>
							<td><input type="text" maxlength="5" name="captcha" value=""></td>
					</tr>

					<tr>
						<td colspan="2">
							<button class="submit" type="submit" name="admin_settings_submit">Submit</button>
							<button class="reset">Reset</button>
						</td>
					</tr>
				</table>
			</form>

		</div>
	</div>
	<?php include_once('../global/footer.php');?>
</body>

</html>
