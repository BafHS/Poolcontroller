//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the flipswitch
var esp_pic = document.getElementById("esp_x");
var esp_0 = document.getElementById("esp_0");
var esp_1 = document.getElementById("esp_1");

//Create an array for easy access later
var Buttons = [ esp_0, esp_1];

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_esp ( pic, url ) {
var data = 0;
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "../script/esp.php?url=" + url, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			//alert (data+" das kam zurück!" );
				//update the index pic
				if ( !(data.localeCompare("on")) ){
					document.getElementById("esp_"+pic).checked = true;
				}
				else if ( !(data.localeCompare("off")) ) {
					document.getElementById("esp_"+pic).checked =false;
				}
				else if ( !(data.localeCompare("fail"))) {
					alert ("Prüfe das Script hier stimmt was nicht!" );
					return ("fail");			
				}
				else {
					alert ("Prüfe das Script hier stimmt was nicht!" );
					return ("fail"); 
				}
		}
		//test if fail
		else if (request.readyState == 4 && request.status == 500) {
			alert ("server error");
			return ("fail");
		}
		//else 
		else if (request.readyState == 4 && request.status != 200 && request.status != 500 ) { 
			alert ("Something went wrong!");
			return ("fail"); }
	}	
	
return 0;
}
