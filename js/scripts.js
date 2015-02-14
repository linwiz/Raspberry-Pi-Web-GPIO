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
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			var ajaxDisplay = document.getElementById('section');
			$(ajaxDisplay).html(ajaxRequest.responseText);
		}
	};
	switch(secID) {
		// Pins page.
		case 1:
			ajaxRequest.open("GET", "page.php?pageType=pins&sort=pinNumberBCM%2B0", true);
			break;
		// Log page.
		case 2:
			ajaxRequest.open("GET", "page.php?pageType=log&id1=0&id2=99999&pn=1", true);
			break;
		// Config page.
		case 3:
			ajaxRequest.open("GET", "page.php?pageType=config", true);
			break;
		// Edit page.
		case 4:
			ajaxRequest.open("GET", "page.php?pageType=edit", true);
			break;
		default:
	}
	ajaxRequest.send(null);
}

function showPage() {
	var pageType = ["null", "pins", "log", "config", "edit"];
	var ajaxRequest = getAjaxRequest();
	var elementID = pageType[arguments[0]];
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			var ajaxDisplay = document.getElementById(elementID);
			$(ajaxDisplay).html(ajaxRequest.responseText);
		}
	};
	switch(arguments[0]) {
		// Pins page.
		case 1:
			// Params: sort pinID field sortDir
			var queryString = "?pageType=" + pageType[arguments[0]]  + "&sort=" + arguments[1] + "&id=" + arguments[2] + "&field=" + arguments[3] + "&sortDir=" + arguments[4];
			break;
		// Log page.
		case 2:
			// Params: none
		        var id1 = document.getElementById('id1').value;
        		var id2 = document.getElementById('id2').value;
			var pn = arguments[1];
			var truncate = arguments[2];

			if (truncate == 'true') {
				var truncate = 'true';
			} else {
				var truncate = 'false';
			}
			// Check for positive integers.
			if (!isNormalInteger(id1)) {
				var id1 = 0;
			}
			if (!isNormalInteger(id2)) {
				var id2 = 99999;
			}
			// This doesn't work.
			if (!isNormalInteger(pn)) {
				//var pn = 1;
			}

			// id1 must be <= id2.
			if (parseInt(id1) > parseInt(id2)) {
				var id1 = 0;
			}
			// id2 must be >= id1.
			if (parseInt(id2) < parseInt(id1)) {
				var id2 = 99999;
			}
	        	var queryString = "?pageType=" + pageType[arguments[0]]  + "&id1=" + id1 + "&id2=" + id2 + "&pn=" + pn + "&truncate=" + truncate;
			break;
		// Config page.
		case 3:
			switch(arguments[1]) {
				case 1:
					var queryParams = "&debugMode=" + arguments[2];
					break;
				case 2:
					var queryParams = "&showDisabledPins=" + arguments[2];
					break;
				case 3:
				        var logPageSize = document.getElementById('logPageSize').value;
					var queryParams = "&logPageSize=" + logPageSize;
					break;
				case 4:
					var queryParams = "&enableLogging=" + arguments[2];
					break;
				case 5:
					var queryParams = "&showBCMNumber=" + arguments[2];
					break;
				case 6:
					var queryParams = "&showWPiNumber=" + arguments[2];
					break;
				case 7:
					var queryParams = "&showDisableBox=" + arguments[2];
					break;
				case 8:
				        var pinDelay = document.getElementById('pinDelay').value;
					var queryParams = "&pinDelay=" + pinDelay;
					break;
				case 9:
				        var chPassword1 = document.getElementById('chPassword1').value;
				        var chPassword2 = document.getElementById('chPassword2').value;
					if (chPassword1 != chPassword2) {
						$('.errormess').html('<b style="color: red;">Passwords do not match.</b>');
						chPassword1.value = '';
						chPassword2.value = '';
						break;
					}
					else if (chPassword1 == '' || chPassword2 == '') {
						$('.errormess').html('<b style="color: red;">Passwords must not be blank.</b>');
						break;
					}
					var queryParams = "&chPassword1=" + chPassword1 + "&chPassword2=" + chPassword2;
					break;
				case 10:
					var queryParams = "&serverStatus=" + arguments[2];
					break;
				default:
			}
			var queryString = "?pageType=" + pageType[arguments[0]] + "&updateConfig=1" + queryParams;
			break;
		// Edit page.
		case 4:
			// Params: pin description fields
			var queryString = "?pageType=" + pageType[arguments[0]];
			var editPinList = arguments[1];
			for (i = 0; i < editPinList.length; i++) {
				var editPinValue = document.getElementById('editPin' + editPinList[i]).value;
				queryString += "&editPin" + editPinList[i] + "=" + editPinValue;
			}
			break;
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
			$('.errormess').html('Please Insert Your Username');
			return false; // stop the script
		}
		var password = $("input#password").val(); // define password variable
		if (password == "") { // if password variable is empty
			$('.errormess').html('Please Insert Your Password');
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
					$('.errormess').html('<b style="color: red;">Username or password incorrect.</b>');
				} else { // if the reurned data not equal 0
					$('.errormess').html('<b style="color: green;">You are logged in. Wait for redirection.</b>');
					changeSection(1);
				}
			}
		});
		return false;
	});
});
