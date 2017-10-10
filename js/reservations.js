// START initial state of common vars
var processStage = "open";
var reservationId = "open";
// END initial state of common vars

//**** START get buttons for availble seats
function showSeats(tbl){
	// If they have unfinished reservation, cancel it	
	if (processStage == "closed"){
		cancelReserve(reservationId);
	}

	// tbl gives us -> tbid_3
	// We only need the (3) part so we split it
	var a = tbl.split("_");
	// Add placeholder text to seatBtns div
	document.getElementById("returnData").innerHTML = 'Double Checking Availability ...';
	
	// For in depth of following code
	// visit http://www.developphp.com/view.php?tid=1185
    var hr = new XMLHttpRequest();
	// PHP processing script url
	var url = "resProcessing.php";
	hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			// Send seat buttons to div id seatBtns
			document.getElementById("returnData").innerHTML = return_data;
	    }
    }
	// Send getSeatBtns=3 to PHP processing script
    hr.send("getSeatBtns="+a[1]);
}
//**** END get buttons for availble seats

//**** START reserve number of seats
function reserveSeats(numseats){
	processStage = "closed";
	// numseats gives us -> tbid_2_3
	// 2 is the id of the table(id not table name)
	// 3 is the number of seats they want
	// Split our data at the _
	var a = numseats.split("_");
	// Add text while request processes to buyNow div
	document.getElementById("returnData").innerHTML = 'Double Checking Availability ...';
	
	// For in depth of following code
	// visit http://www.developphp.com/view.php?tid=1185
    var hr = new XMLHttpRequest();
	// PHP processing script url
	var url = "resProcessing.php";
	hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText.split("|");
			reservationId = return_data[1];
			// Return data sent to buyNow div
			document.getElementById("returnData").innerHTML = return_data[0];
	    }
    }
	// Send reserve=2&num=3 to PHP processing script
    hr.send("reserve="+a[1]+"&num="+a[2]);
}
//**** END reserve number of seats

//**** START register/buy seats
function confirmSeats(){
	// Get form values
	var name = document.getElementById("name").value;
	var tnum = document.getElementById("tableNumber").value;
	var nseats = document.getElementById("numSeats").value;
	var rid = document.getElementById("reserveID").value;
	if(name == "" || tnum == "" || nseats == "" || rid == ""){
		return false;
	}
	// Compile our data from form to send to processing
	var confData = "confirm="+rid+"&n="+name+"&tn="+tnum+"&ns="+nseats;
	
	// For in depth of following code
	// visit http://www.developphp.com/view.php?tid=1185
    var hr = new XMLHttpRequest();
	// PHP processing script url
	var url = "resProcessing.php";
	hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText.split("|");
			// They farted around too long and someone else got the seats
			if (return_data[0] == "false"){
				// Display fail message
				document.getElementById("returnData").innerHTML = return_data[1];
				var processStage = "open";
				var reservationId = "open";
			} else {
				// They got the seats succesfully
				var processStage = "open";
				var reservationId = "open";
				// Alert the success message
				alert ("You own the seats");
				// Reload the page
				window.location = 'auction.php';
			}
	    }
    }
	// Send our compiled data
    hr.send(confData);
}
//**** END register/buy seats

// START cancel reservation button
function cancelReserve(resId){
	// For in depth of following code
	// visit http://www.developphp.com/view.php?tid=1185
    var hr = new XMLHttpRequest();
	// PHP processing script url
	var url = "resProcessing.php";
	hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// Send reservation id
    hr.send("clearRes="+resId);
	window.location = 'auction.php';	
}
// END cancel reservation button
