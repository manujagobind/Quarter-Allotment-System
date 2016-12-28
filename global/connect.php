<?php
require("config.php");

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if(!$conn)
	die("Database Connection: " . mysqli_error());

$db = mysqli_select_db($conn, DB_NAME);
if(!$db)
	die("Database Selection Failed: " . mysqli_error());	
?>