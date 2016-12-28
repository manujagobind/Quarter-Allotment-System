<?php
session_start();

//Make sure admin is logged in
if(!isset($_SESSION['emp_pis'])){
	header('location: login.php');
}

unset($_SESSION['emp_pis']);
unset($_SESSION['emp_status']);
header('location: ../index.php');
?>