function getAjaxRequestObject(){
	var request;
	try{
		request = new XMLHttpRequest();
	}
	catch(e){
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				alert("Ajax not supported on this browser!");
				return false;
			}
		}
	}
	return request;
}

function getQuarterNumbers(QType){

	request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('QNo');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_quarter_numbers.php?type=" + QType, true);
	request.send(null);
}

function getVacantQuarters(QType){

	request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('allot_QNo');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_vacant_quarters.php?type=" + QType, true);
	request.send(null);
}

function getOccupiedQuarters(QType){

	request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('vacate_QNo');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_occupied_quarters.php?type=" + QType, true);
	request.send(null);
}

function quickStatus(){

	request = getAjaxRequestObject();

	var type = document.getElementById('QType');
	var num = document.getElementById('QNo');
	var query_str = "?QType=" + type.value + "&QNo=" + num.value;

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('dispQStatus');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_quarter_details.php" + query_str, true);
	request.send(null);
}


function getQStatusByCategory(category, page){

	//alert(category);
	//alert(page);
	request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('dispQStatus');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_quarter_status.php?category=" + category + "&page=" + page, true);
	request.send(null);
}

function allotQuarter(){

	var refNo = document.getElementById('allot_refNo').value;
	var QType = document.getElementById('allot_QType').value;
	var QNo = document.getElementById('allot_QNo').value;

	//TODO: Verify reference number

	var query = "?refNo=" + refNo + "&QType=" + QType + "&QNo=" + QNo;

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){

			var response = document.getElementById('allotmentResult');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/allot_quarter.php" + query, true);
	request.send(null);
}

function vacateQuarter(){

	var refNo = document.getElementById('vacate_refNo').value;
	var QType = document.getElementById('vacate_QType').value;
	var QNo = document.getElementById('vacate_QNo').value;

	//TODO: Verify reference number

	var query = "?refNo=" + refNo + "&QType=" + QType + "&QNo=" + QNo;

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){

			var response = document.getElementById('allotmentResult');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/vacate_quarter.php" + query, true);
	request.send(null);
}


function applicationLookup(key){

	var queryStr = "";
	if(key == 'emp_pis'){
		var emp_pis = document.getElementById('emp_pis').value;
		queryStr = "?emp_pis=" + emp_pis;
	}
	else if(key == 'app_refNo'){
		var app_refNo = document.getElementById('app_refNo').value;
		queryStr = "?app_refNo=" + app_refNo;
	}
	else
		return;

	var request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('searchResult');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/application_lookup.php" + queryStr, true);
	request.send(null);
}

function retrieveApplications(status){

	request = getAjaxRequestObject();

	document.getElementById('applications_range').innerHTML = "";

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){

			var page_heading = document.getElementById('applications_category');
			page_heading.innerHTML = status;

			var response = document.getElementById('dispApplications');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/application_lookup.php?category=" + status, true);
	request.send(null);
}

function retrieveApplicationsInRange(){

	var status = document.getElementById('applications_category').innerHTML;
	if(!status){
		alert('Select an option before setting date range!');
	}
	else{
		request = getAjaxRequestObject();

		var range_lb = document.getElementById('range_lb').value;
		var range_ub = document.getElementById('range_ub').value;

		var query = "?category=" + status + "&from="  + range_lb + "&to=" + range_ub;
		document.getElementById('applications_range').innerHTML = " between " + range_lb + " and " + range_ub;

		request.onreadystatechange = function(){

			if(request.readyState == 4 && request.status == 200){

				var response = document.getElementById('dispApplications');
				response.innerHTML = request.responseText;
			}
		}

		request.open("GET", "scripts/application_lookup.php" + query, true);
		request.send(null);
	}
}

function getBriefQuarterSummary(){

	var request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){

			var response = document.getElementById('dispQStatus');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_current_quarter_status.php", true);
	request.send(null);
}

function getAnnualReport(year){

	var request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){

			var response = document.getElementById('dispAnnualReport');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_annual_report.php?year=" + year, true);
	request.send(null);
}
