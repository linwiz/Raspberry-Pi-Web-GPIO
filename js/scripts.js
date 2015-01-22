// Check for positive integers.
function isNormalInteger(str) {
	var n = ~~Number(str);
	return String(n) === str && n >= 0;
}

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
			ajaxRequest.open("GET", "page.php?pageType=log&id1=0&id2=99999&pn=1", true);
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
			var pn = arguments[1];
			// Check for positive integers.
			if (!isNormalInteger(id1)) {
				var id1 = 0;
			}
			if (!isNormalInteger(id2)) {
				var id2 = 99999;
			}
			if (!isNormalInteger(pn)) {
				var pn = 1;
			}

			// id1 must be <= id2.
			if (parseInt(id1) > parseInt(id2)) {
				var id1 = 0;
			}
			// id2 must be >= id1.
			if (parseInt(id2) < parseInt(id1)) {
				var id2 = 99999;
			}
	        	var queryString = "?pageType=" + pageType[arguments[0]]  + "&id1=" + id1 + "&id2=" + id2 + "&pn=" + pn;
			break;
		case 3:
			// Params: updateConfig debugMode showDisabledPins logPageSize
			var queryString = "?pageType=" + pageType[arguments[0]]  + "&updateConfig=" + arguments[1] + "&debugMode=" + arguments[2] + "&showDisabledPins=" + arguments[3] + "&logPageSize=" + arguments[4] + "&enableLogging=" + arguments[5];
		default:
 	}
        ajaxRequest.open("GET", "ajax.php" + queryString, true);
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
					changeSection(1);
				}
			}
		});
		return false;
	});
});
