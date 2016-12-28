<?php
//Well, this one's the blackbox.

function validatePIS($emp_pis){

	//PIS Numbers are always 8 digit integers
	if(strlen((string)$emp_pis) == 8 AND  filter_var($emp_pis, FILTER_VALIDATE_INT)){
		return true;
	}
	return false;
}

function validateReferenceNumber($refNo){

	//Reference Numbers are natural numbers
	if(filter_var($refNo, FILTER_VALIDATE_INT) AND $refNo > 0){
		return true;
	}
	return false;
}

function validateEmail($email){

	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		return true;
	}
	return false;
}

function validatePassword($password){

	//Passwords comprise 8-10 characters
	//$password = filter_var($password, FILTER_SANITIZE_STRING);
	if(strlen((string)$password) >= 8 AND strlen((string)$password) <= 20){
		return true;
	}
	return false;
}

function validateDateRange($range_lb, $range_ub){

	$default = date('Y-m-d', strtotime('1970-01-01'));
	$range_lb = date('Y-m-d', strtotime($range_lb));
	$range_ub = date('Y-m-d', strtotime($range_ub));

	if($range_lb > $default AND $range_ub > $default){
		if($range_lb <= $range_ub)
			return true;
	}
	return false;
}

function validateApplicationStatusCategory($category){

	if($category == 'All' OR $category == 'Pending' OR $category == 'Approved' OR $category == 'Rejected' OR $category == 'Vacated'){
		return true;
	}
	return false;
}

function verifyCaptcha($captcha){
	if($_SESSION['digit'] == $captcha)
		return true;
	return false;
}

function updateEmpPassword($conn, $emp_pis, $newpass1, $newpass2){

	$newpass1 = md5($newpass1);
	$newpass2 = md5($newpass2);

	$flag = false;
	$error = "";

	//If both passwords match
	if($newpass1 === $newpass2){

		$query = "UPDATE `login` SET `PASSWORD` = '$newpass1', `Count`=1 WHERE `PISNo` = $emp_pis";
		$query_result = mysqli_query($conn, $query);

		if($query_result){
			//Update employee login status after password change
			$flag = true;
			$error = "<p style='color:green;'>Password updated!</p>";
		}
		else{
			$error = "<p style='color:red;>Password not updated</p>";
			die(mysqli_error());
		}
	}
	else{
		$error = "<p style='color:red;'>Passwords don't match!</p>";
	}
	return array($flag, $error);
}

function updateAdminPassword($conn, $admin_id, $newpass1, $newpass2){

	$newpass1 = md5($newpass1);
	$newpass2 = md5($newpass2);

	$flag = false;
	$error = "";

	//If both passwords match
	if($newpass1 === $newpass2){

		$query = "UPDATE `administrator` SET `ADMIN_PASS` = '$newpass1' WHERE `ADMIN_ID` = '$admin_id'";
		$query_result = mysqli_query($conn, $query);

		if($query_result){

			$flag = true;
			$error = "<p style='color:green;'>Password updated!</p>";
		}
		else{
			$error = "<p style='color:red;'>Password not updated</p>";
			die(mysqli_error());
		}
	}
	else{
		$error = "<p style='color:red;'>Passwords don't match!</p>";
	}
	return array($flag, $error);
}

function employeeLogin($conn, $emp_pis, $emp_pass){

	$emp_pass = md5($emp_pass);
	$flag = false;
	$error = "";

	//Extracting employee details from database
	$query = "SELECT * FROM `login` WHERE `PISNo` = $emp_pis";
	$query_result = mysqli_query($conn, $query);

	if(!$query_result){
		die(mysqli_error($conn));
	}
	echo $query;
	//If PIS Number was valid
	if(mysqli_num_rows($query_result) == 1){

		$emp_login_details = mysqli_fetch_assoc($query_result);
		$emp_status = $emp_login_details['Count'];

		//If employee has not registered, ie. if Count = 0
		if(!$emp_status){
			$error = "<p style='color:red;'>PIS Number not registered.</p>";
		}
		else{
			//Verify password
			if($emp_pass == $emp_login_details['PASSWORD']){
				$flag = true;
			}
			else{
				$error = "<p style='color:red;'>Invalid password!</p>";
			}
		}
	}
	else{
		$error = "<p style='color:red;'>Invalid PIS Number!</p>";
	}

	return array($flag, $error);
}

function employeeRegister($conn, $emp_pis, $emp_pan){

	$flag = false;
	$error = "";

	//Fetching employee details
	$query = "SELECT * FROM `login` WHERE `PISNo` = $emp_pis";
	$query_result = mysqli_query($conn, $query);

	if(!$query_result){
		die(mysqli_error($conn));
	}

	//If PIS was valid
	if(mysqli_num_rows($query_result) == 1){

		$query_fetch = mysqli_fetch_assoc($query_result);
		$emp_status = $query_fetch['Count'];	//Count: 0 ==> New user, Count: 1 ==> Returning user

		//If employee is a returning user (ie. if count is 1):
		if($emp_status){
			$error = "<p style='color:red'>This PIS number is already registered! You may login instead.</p>";
		}
		//If employee is a first time user:
		else{
			//Verify PAN number
			if($emp_pan == $query_fetch['PASSWORD']){
				$flag = true;
			}
			else{
				$error = "<p style='color:red'>Invalid PAN Number!</p>";
			}
		}
	}
	else{
		$error = "<p style='color:red'>PIS Number doesn't match from our records!</p>";
	}

	return array($flag, $error);
}

function adminLogin($conn, $admin_id, $admin_pass){

	$flag = false;
	$error = "";
	$admin_pass = md5($admin_pass);

	//Fetch admin details
	$query = "SELECT * FROM `administrator` WHERE `ADMIN_ID` = '$admin_id' AND `ADMIN_PASS` = '$admin_pass'";
	$query_result = mysqli_query($conn, $query);

	if(!$query_result){
		mysqli_error($conn);
	}

	//If login details were valid
	if(mysqli_num_rows($query_result) == 1){

		$flag = true;
	}
	else{
		$error = "<p style='color:red'>Invalid credentials!</p>";
	}

	return array($flag, $error);
}

function getEmployeeDetails($conn, $emp_pis){

	//Sanitize
	$emp_pis = mysqli_real_escape_string($conn, $emp_pis);

	$query  = "SELECT * FROM `employee` ";
	$query .= "JOIN `department` ON `employee`.`DeptNo` = `department`.`DeptNo` ";
	$query .= "WHERE `PISNo` = $emp_pis";

	$query_result = mysqli_query($conn, $query);
	$employee_details = false;

	if($query_result){
		$employee_details = mysqli_fetch_assoc($query_result);
	}

	return $employee_details;
}

function hasAppliedAlready($conn, $emp_pis){

	//Sanitize
	$emp_pis = mysqli_real_escape_string($conn, $emp_pis);

	$query = "SELECT * FROM `quarter_request` WHERE `PISNo` = $emp_pis";
	$query_result = mysqli_query($conn, $query);

	if(!$query_result)
		die(mysqli_error());

	if(mysqli_num_rows($query_result))
		return true;

	return false;
}

function submitApplication($conn, $emp_pis, $emp_salary, $emp_grade, $emp_residence, $emp_quarterType){

	$emp_pis = mysqli_real_escape_string($conn, $emp_pis);
	$emp_salary = mysqli_real_escape_string($conn, $emp_salary);
	$emp_grade = mysqli_real_escape_string($conn, $emp_grade);
	$emp_residence = mysqli_real_escape_string($conn, $emp_residence);
	$emp_quarterType = mysqli_real_escape_string($conn, $emp_quarterType);

	$query = "INSERT INTO `quarter_request` (`RefNo`, `ReqDate`, `PISNo`, `Salary`, `Grade`, `Residence`, `QType`) VALUES (NULL, CURRENT_TIMESTAMP, $emp_pis, $emp_salary, '$emp_grade', '$emp_residence', '$emp_quarterType')";

		if(mysqli_query($conn, $query)){

			//Fetch application reference number for the request submitted and store in reference table
			$query2 = "SELECT `RefNo` FROM `quarter_request` WHERE `PISNo` = $emp_pis ORDER BY `ReqDate` DESC";
			$query2_result = mysqli_query($conn, $query2);

			if($query2_result){

				$query2_fetch = mysqli_fetch_assoc($query2_result);
				$app_refNo = $query2_fetch['RefNo'];
				$query3 = "INSERT INTO `application_ref` (`RefNo`) VALUES ($app_refNo)";

				if(mysqli_query($conn, $query3)){
					return $app_refNo;
				}
			}
		}
		else
			return false;
}

function generateApplicationLookupQuery($emp_pis=null, $app_refNo=null, $category=null, $range_lb=null, $range_ub=null){

	$query  = "SELECT `quarter_request`.`RefNo`, `quarter_request`.`PISNo`, `quarter_request`.`ReqDate`, `application_ref`.`RefStatus` ";
	$query .= "FROM `quarter_request`, `application_ref` ";

	if($emp_pis){
		$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND `quarter_request`.`PISNo` = $emp_pis";
	}
	else if($app_refNo){
		$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND `quarter_request`.`refNo` = $app_refNo";
	}
	else if($category){

		if($range_lb AND $range_ub){
			if($category == 'All'){
				$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND DATE(`ReqDate`) BETWEEN '$range_lb' AND '$range_ub' ORDER BY `ReqDate` DESC";
			}
			else{
				$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND DATE(`ReqDate`) BETWEEN '$range_lb' AND '$range_ub' AND `application_ref`.`RefStatus` = '$category' ORDER BY `ReqDate` DESC";
			}
		}
		else{
			if($category == 'All'){
				$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` ORDER BY `ReqDate` DESC";
			}
			else{
				$query .= "WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND `application_ref`.`RefStatus` = '$category' ORDER BY `ReqDate` DESC";
			}
		}
	}
	else{
		$query = false;
	}
	return $query;
}

function listApplications($query_result){

	$response_str = "<table>";
	$response_str .= "<tr>";
	$response_str .= "<th><strong>Reference No	</strong></th>";
	$response_str .= "<th><strong>PIS No</strong></th>";
	$response_str .= "<th><strong>Date</strong></th>";
	$response_str .= "<th><strong>Status</strong></th>";
	$response_str .= "<th><strong>Action</strong></th>";
	$response_str .= "</tr>";

	while($row = mysqli_fetch_assoc($query_result)){
		$app_refNo = $row['RefNo'];

		$response_str .= "<tr>";
		$response_str .= "<td>$row[RefNo]</td>";
		$response_str .= "<td>$row[PISNo]</td>";
		$response_str .= "<td>$row[ReqDate]</td>";
		$response_str .= "<td>$row[RefStatus]</td>";
		$response_str .= "<td> <button><a href='scripts/view_application.php?app_ref=$app_refNo'>View</a></button>";
		if($row['RefStatus'] == 'Pending'){
			$response_str .= " | <button><a href='scripts/application_action.php?app_ref=$app_refNo&action=r'>Reject</a></button>";
		}
		$response_str .= "</td></tr>";
	}
	$response_str .= "</table>";
	return $response_str;
}

function listApplicationsMinimal($query_result){
	//Without any action buttons
	$response_str = "<table>";
	$response_str .= "<tr>";
	$response_str .= "<th><strong>Reference No	</strong></th>";
	$response_str .= "<th><strong>PIS No</strong></th>";
	$response_str .= "<th><strong>Date</strong></th>";
	$response_str .= "<th><strong>Status</strong></th>";
	$response_str .= "</tr>";

	$row = mysqli_fetch_assoc($query_result);
	$app_refNo = $row['RefNo'];

	$response_str .= "<tr>";
	$response_str .= "<td>$row[RefNo]</td>";
	$response_str .= "<td>$row[PISNo]</td>";
	$response_str .= "<td>$row[ReqDate]</td>";
	$response_str .= "<td>$row[RefStatus]</td>";
	$response_str .= "</td></tr>";

	$response_str .= "</table>";
	return $response_str;
}

function getApplicationStatus($conn, $emp_pis){

	$query = "SELECT `quarter_request`.`RefNo`, `quarter_request`.`ReqDate`, `application_ref`.`RefStatus` FROM `quarter_request`, `application_ref` WHERE `quarter_request`.`RefNo` = `application_ref`.`RefNo` AND `quarter_request`.`PISNo` = $emp_pis ORDER BY `ReqDate` DESC";
	$query_result = mysqli_query($conn, $query);
	$response_str = "";

	if($query_result){

		if(mysqli_num_rows($query_result) == 0){
			$response_str = "<br/><p>No history of applications!</p><br/>";
		}
		else{
			$response_str .= "<table>";
			$response_str .= "<tr>";
			$response_str .= "<th><strong>Reference No</strong></th>";
			$response_str .= "<th><strong>Date</strong></th>";
			$response_str .= "<th><strong>Status</strong></th>";
			$response_str .= "</tr>";

			$application_history = mysqli_fetch_assoc($query_result);

			//Display
			$response_str .= "<tr>";
			$app_refno = $application_history['RefNo'];
			$response_str .= "<td>$app_refno</td>";
			$response_str .= "<td>$application_history[ReqDate]</td>";
			$response_str .= "<td>$application_history[RefStatus]</td>";
			$response_str .= "</tr>";
			$response_str .= "</table><br/>";

			if($application_history['RefStatus'] == 'Approved'){

				$query2 = "SELECT * FROM `allotment` WHERE `RefNo` = $app_refno";
				$query2_result = mysqli_query($conn, $query2);

				if($query2_result){

					$allotment_details = mysqli_fetch_assoc($query2_result);
					$response_str .= "<table>";
					$response_str .= "<tr><th>Quarter Type</th><th>Quarter Number</th></tr>";
					$response_str .= "<tr><td>$allotment_details[QType]</td><td>$allotment_details[QNo]</td></tr>";
					$response_str .= "</table>";
				}
			}
		}
	}
	return $response_str;
}

function getQuarterReport($conn, $type){

	$type = mysqli_real_escape_string($conn, $type);
	$response_str = "";

	$total_query = "SELECT COUNT(*) FROM `quarter_status` WHERE `Qtype` = '$type'";
	$vacant_query = "SELECT COUNT(*) FROM `quarter_status` WHERE `Qtype` = '$type' AND `QStatus` = 'Vacant'";
	$occupied_query = "SELECT COUNT(*) FROM `quarter_status` WHERE `Qtype` = '$type' AND `QStatus` = 'Occupied'";
	$damaged_query = "SELECT COUNT(*) FROM `quarter_status` WHERE `Qtype` = '$type' AND `QStatus` = 'Damaged'";

	$total_query_result = mysqli_query($conn, $total_query) or die(mysqli_error($conn));
	$vacant_query_result = mysqli_query($conn, $vacant_query) or die(mysqli_error($conn));
	$occupied_query_result = mysqli_query($conn, $occupied_query) or die(mysqli_error($conn));
	$damaged_query_result = mysqli_query($conn, $damaged_query) or die(mysqli_error($conn));

	$total = mysqli_fetch_array($total_query_result);
	$vacant = mysqli_fetch_array($vacant_query_result);
	$occupied = mysqli_fetch_array($occupied_query_result);
	$damaged = mysqli_fetch_array($damaged_query_result);

	$response_str = "<table>";
	$response_str .= "<tr><th>Total</th><th>Vacant</th><th>Occupied</th><th>Damaged</th></tr>";
	$response_str .= "<tr><td>$total[0]</td><td>$vacant[0]</td><td>$occupied[0]</td><td>$damaged[0]</td></tr>";
	$response_str .= "</table>";

	return $response_str;
}

function getAllotmentHistory($conn, $QType, $QNo){

	//$QType = mysql_real_escape_string($conn, $QType);
	//$QNo = mysql_real_escape_string($conn, $QNo);

	$response_str = "";

	$query = "SELECT * FROM `allotment` WHERE `QType` = '$QType' AND `QNo` = $QNo ORDER BY `StartDate` DESC";
	$query_result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	if(mysqli_num_rows($query_result)){
		$response_str  = "<table>";
		$response_str .= "<tr><th>Start Date</th><th>End Date</th><th>Ref No</th><th>Alloted To</th></tr>";
		while($row = mysqli_fetch_assoc($query_result)){

			$pis_query = "SELECT `PISNo` FROM `quarter_request` WHERE `RefNo` = $row[RefNo]";
			$pis_query_result = mysqli_query($conn, $pis_query) or die(mysqli_error($conn));

			$pis = mysqli_fetch_array($pis_query_result);

			$response_str .= "<tr><td>$row[StartDate]</td><td>$row[EndDate]</td><td>$row[RefNo]</td><td>$pis[0]</td></tr>";
		}
		$response_str .= "</table>";
	}
	else{
		$response_str = "No history of allotment.";
	}

	return $response_str;
}

?>
