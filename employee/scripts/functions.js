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

function showQuarterType(emp_grade){

	request = getAjaxRequestObject();

	request.onreadystatechange = function(){

		if(request.readyState == 4 && request.status == 200){
			var response = document.getElementById('quarter_type');
			response.innerHTML = request.responseText;
		}
	}

	request.open("GET", "scripts/get_quarter_types_by_grade.php?emp_grade="+emp_grade, true);
	request.send(null);
}

function applicationLookupMinimal(key){

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

	request.open("GET", "scripts/application_lookup_minimal.php" + queryStr, true);
	request.send(null);
}
