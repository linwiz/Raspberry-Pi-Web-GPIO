// Common ajaxRequest variable creation.
function getAjaxRequest() {
	var ajaxRequest;
	try {
		// Opera 8.0+, Firefox, Safari.
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers.
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				// Something went wrong.
				alert("Your browser broke!");
				return false;
			}
		}
	}
	return ajaxRequest;
}

// Paku - change the main section content.
function changeSection(secID) {
	var ajaxRequest = getAjaxRequest();
	// Create a function that will receive data sent from the server.
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			var ajaxDisplay = document.getElementById('section');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	};
	switch(secID) {
		case 1:
			ajaxRequest.open("GET", "page.php?pageType=pins&sort=pinNumberBCM%2B0", true);
			break;
		case 2:
			ajaxRequest.open("GET", "page.php?pageType=log&id1=0&id2=99999", true);
			break;
		case 3:
			ajaxRequest.open("GET", "page.php?pageType=config", true);
			break;
		default:
	}
	ajaxRequest.send(null);
}

function showPage() {
	var pageType = ["null", "pins", "log", "config"];
	var ajaxRequest = getAjaxRequest();
	var elementID = pageType[arguments[0]];
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			var ajaxDisplay = document.getElementById(elementID);
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	};
	switch(arguments[0]) {
		case 1:
			// Params: sort pinID field
			var queryString = "?pageType=" + pageType[arguments[0]]  + "&sort=" + arguments[1] + "&id=" + arguments[2] + "&field=" + arguments[3];
			break;
		case 2:
			// Params: none
		        var id1 = document.getElementById('id1').value;
        		var id2 = document.getElementById('id2').value;
	        	var queryString = "?pageType=" + pageType[arguments[0]]  + "&id1=" + id1 + "&id2=" + id2;
			break;
		case 3:
			// Params: updateConfig debugMode showDisabledPins logPageSize
			var queryString = "?pageType=" + pageType[arguments[0]]  + "&updateConfig=" + arguments[1] + "&debugMode=" + arguments[2] + "&showDisabledPins=" + arguments[3] + "&logPageSize=" + arguments[4];
		default:
 	}
        ajaxRequest.open("GET", "ajax.php" + queryString, true);
        ajaxRequest.send(null);
}

function showNavigation(loggedin) {
	var ajaxRequest = getAjaxRequest();
	// Create a function that will receive data sent from the server.
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			if (loggedin == 1) {
				var ajaxDisplay = document.getElementById('nav');
				ajaxDisplay.innerHTML = '<a href="#" onclick="changeSection(1)">PINs</a> ';
				ajaxDisplay.innerHTML = ajaxDisplay.innerHTML + '<a href="#" onclick="changeSection(2)">Log</a> ';
				ajaxDisplay.innerHTML = ajaxDisplay.innerHTML + '<a href="#" onclick="changeSection(3)">Config</a> ';
				ajaxDisplay.innerHTML = ajaxDisplay.innerHTML + ajaxRequest.responseText;
			} else {
				var ajaxDisplay = document.getElementById('nav');
				ajaxDisplay.innerHTML = '';
			}
		}
	};
	ajaxRequest.open("GET", "status.php", true);
	ajaxRequest.send(null);
}

///////////////////////////////////////////////////////
// jquery 
///////////////////////////////////////////////////////

$(function() {
	// Login processing.
	$("#submit_login").click(function() { // if submit button is clicked
		var username = $("input#username").val(); // define username variable
		if (username == "") { // if username variable is empty
			$('.errormess').html('Please Insert Your Username'); // printing error message
			return false; // stop the script
		}
		var password = $("input#password").val(); // define password variable
		if (password == "") { // if password variable is empty
			$('.errormess').html('Please Insert Your Password'); // printing error message
			return false; // stop the script
		}

		$('.errormess').html('Checking...');
		$.ajax({ // JQuery ajax function
			type: "POST", // Submitting Method
			url: 'ajax.php', // PHP processor
			data: 'username='+ username + '&password=' + password, // the data that will be sent to php processor
			dataType: "html", // type of returned data
			success: function(data) { // if ajax function results success
				if (data == 0) { // if the returned data equal 0
					$('.errormess').html('Wrong Login Data'); // print error message
				} else { // if the reurned data not equal 0
					$('.errormess').html('<b style="color: green;">You are logged in. Wait for redirection.</b>');// print success message
					showNavigation(1);
					changeSection(1);
				}
			}
		});
		return false;
	});
});
