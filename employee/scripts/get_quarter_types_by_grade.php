<?php
$emp_grade = $_GET['emp_grade'];
$response = "";

if($emp_grade == 'E1' || $emp_grade == 'E2' || $emp_grade == 'E3' || $emp_grade == 'E4')
	$response = "<option value='C'>Type C</option>";
else if($emp_grade == 'E5' || $emp_grade == 'E6' || $emp_grade == 'E7')
	$response = "<option value='B'>Type B</option><option value='C'>Type C</option)";
else if($emp_grade == 'E8')
	$response = "<option value='A'>Type A</option><option value='B'>Type B</option><option value='C'>Type C</option)";

echo $response;
?>