<?php

require_once('global/connect.php');
session_start();

//Check if employee is already logged in
if(isset($_SESSION['emp_pis'])){
	header('location: employee/login.php');
}

?>

<html>

<head>
  <title>Quarter Allotment System</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Online portal for quarter allotment" />
  <meta name="keywords" content="CCL Ranchi, Central Coalfields Limited, CCL Quarter Allotment" />
  <meta name="author" content="Ayush Lal, Gobind Manuja"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="employee/styles/employee.css" />
  <link rel="icon" href="../images/logo.gif" type="image/gif" sizes="16x16">
</head>

<body>

	<?php include_once('global/header.php');?>

	<div id="navbar">

		<ul>
			<li><a class="active" href="index.php">Home</a></li>
			<li><a href="http://www.centralcoalfields.in" target="_blank"> About Us </a></li>
			<li><a href="downloads/Sample.pdf" target="_blank">Notice</a></li>
			<li><a href="employee/register.php">Register</a></li>
			<li><a href="employee/login.php">Login</a></li>
			<li><a href="employee/status_external.php">Check Status</a></li>
			<li style="float:right;"><a href="admin/login.php">Admin</a></li>
		</ul>

	</div>

	<div id="contents">

		<h1>Welcome To Online Quarter Allotment System</h1> <br/>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit sapien, tempus sit amet hendrerit volutpat, euismod vitae risus. Etiam consequat, sem et vulputate dapibus, diam enim tristique est, vitae porta eros mauris ut orci. Praesent sed velit odio. Ut massa arcu, suscipit viverra molestie at, aliquet a metus. Nullam sit amet tellus dui, ut tincidunt justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis egestas laoreet. Nunc non ipsum metus, non laoreet urna. Vestibulum quis risus quis diam mattis tempus. Vestibulum suscipit pretium tempor.</p> <br/>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit sapien, tempus sit amet hendrerit volutpat, euismod vitae risus. Etiam consequat, sem et vulputate dapibus, diam enim tristique est, vitae porta eros mauris ut orci. Praesent sed velit odio. Ut massa arcu, suscipit viverra molestie at, aliquet a metus. Nullam sit amet tellus dui, ut tincidunt justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis egestas laoreet. Nunc non ipsum metus, non laoreet urna. Vestibulum quis risus quis diam mattis tempus. Vestibulum suscipit pretium tempor.</p> <br/>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit sapien, tempus sit amet hendrerit volutpat, euismod vitae risus. Etiam consequat, sem et vulputate dapibus, diam enim tristique est, vitae porta eros mauris ut orci. Praesent sed velit odio. Ut massa arcu, suscipit viverra molestie at, aliquet a metus. Nullam sit amet tellus dui, ut tincidunt justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis egestas laoreet. Nunc non ipsum metus, non laoreet urna. Vestibulum quis risus quis diam mattis tempus. Vestibulum suscipit pretium tempor.</p> <br/>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit sapien, tempus sit amet hendrerit volutpat, euismod vitae risus. Etiam consequat, sem et vulputate dapibus, diam enim tristique est, vitae porta eros mauris ut orci. Praesent sed velit odio. Ut massa arcu, suscipit viverra molestie at, aliquet a metus. Nullam sit amet tellus dui, ut tincidunt justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis egestas laoreet. Nunc non ipsum metus, non laoreet urna. Vestibulum quis risus quis diam mattis tempus. Vestibulum suscipit pretium tempor. </p>

	</div>

   <?php include_once('global/footer.php');?>

</body>

</html>
