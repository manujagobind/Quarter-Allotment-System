<?php

session_start();

//Make sure admin is logged in
if(!isset($_SESSION['admin_id'])){
	header('location: login.php');
}

unset($_SESSION['admin_id']);
header('location: login.php');
?>