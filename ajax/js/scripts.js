<!-- 
// Paku - change the main section content
function changeSection(secID){
    var ajaxRequest;  
    
    try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
    } catch (e){
	// Internet Explorer Browsers
	try{
	    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	    try{
		ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	    } catch (e){
		// Something went wrong
		alert("Your browser broke!");
		return false;
	    }
	}
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
	    var ajaxDisplay = document.getElementById('section');
	    ajaxDisplay.innerHTML = ajaxRequest.responseText;
	}
    }

    switch(secID) {
    case 1:
        ajaxRequest.open("GET", "pins.html", true);        
        break;
    case 2:
        ajaxRequest.open("GET", "log.html", true);
        break;
    case 3:
        ajaxRequest.open("GET", "config.php", true);        
        break;        
    default:
	}     

    ajaxRequest.send(null);    
     
}


//Paku - change the log table content

function showLog(){
    var ajaxRequest;  
    
    try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
    } catch (e){
	// Internet Explorer Browsers
	try{
	    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	    try{
		ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	    } catch (e){
		// Something went wrong
		alert("Your browser broke!");
		return false;
	    }
	}
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
	    var ajaxDisplay = document.getElementById('log');
	    ajaxDisplay.innerHTML = ajaxRequest.responseText;
	}
    }
    var id1  = document.getElementById('id1').value;
    var id2 = document.getElementById('id2').value;
    var queryString = "?id1=" + id1 + "&id2=" + id2;
    ajaxRequest.open("GET", "get_log.php" + queryString, true);
    ajaxRequest.send(null); 
}


//Paku - change the log table content

function showPins(sort){
    var ajaxRequest;  
    
    try{
	// Opera 8.0+, Firefox, Safari
	ajaxRequest = new XMLHttpRequest();
    } catch (e){
	// Internet Explorer Browsers
	try{
	    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	    try{
		ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	    } catch (e){
		// Something went wrong
		alert("Your browser broke!");
		return false;
	    }
	}
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
	if(ajaxRequest.readyState == 4){
	    var ajaxDisplay = document.getElementById('pins');
	    ajaxDisplay.innerHTML = ajaxRequest.responseText;
	}
    }
    //var id1  = document.getElementById('id1').value;
    //var id2 = document.getElementById('id2').value;
    //var queryString = "?id1=" + id1 + "&id2=" + id2;
    var queryString = "?sort="+sort;
    ajaxRequest.open("GET", "get_pins.php" + queryString, true);
    ajaxRequest.send(null); 
}

//-->

