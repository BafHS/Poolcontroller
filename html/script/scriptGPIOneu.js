//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the buttons
var button_0 = document.getElementById("button_0");
var button_1 = document.getElementById("button_1");
var button_2 = document.getElementById("button_2");
var button_3 = document.getElementById("button_3");
var button_4 = document.getElementById("button_4");
var button_5 = document.getElementById("button_5");
var button_6 = document.getElementById("button_6");
var button_7 = document.getElementById("button_7");
var button_8 = document.getElementById("button_8");
var button_9 = document.getElementById("button_9");
var button_10 = document.getElementById("button_10");
var button_11 = document.getElementById("button_11");
var button_12 = document.getElementById("button_12");
var button_13 = document.getElementById("button_13");
var button_14 = document.getElementById("button_14");
var button_15 = document.getElementById("button_15");
var button_16 = document.getElementById("button_16");
var button_17 = document.getElementById("button_17");
var button_18 = document.getElementById("button_18");
var button_19 = document.getElementById("button_19");
var button_20 = document.getElementById("button_20");
var button_21 = document.getElementById("button_21");
var button_22 = document.getElementById("button_22");
var button_23 = document.getElementById("button_23");
var button_24 = document.getElementById("button_24");
var button_25 = document.getElementById("button_25");
var button_26 = document.getElementById("button_26");
var button_27 = document.getElementById("button_27");
var button_28 = document.getElementById("button_28");
var button_29 = document.getElementById("button_29");

//Create an array for easy access later
var Buttons = [ button_0, button_1, button_2, button_3, button_4, button_5, button_6, button_7, button_8, button_9, button_10, button_11, button_12, button_13, button_14, button_15, button_16, button_17, button_18, button_19, button_20, button_21, button_22, button_23, button_24, button_25, button_26, button_27, button_28, button_29];

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_pin ( pic ) {
var data = 0;
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "../script/gpioneu.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			if (pic <=7) {
				//update the index pic
				if ( !(data.localeCompare("1")) ){
					// so ist das Buttons[pic].src = "data/img/red/red_"+pic+".jpg"
					// Buttons[pic].src = "data/img/red/red.jpg";
					Buttons[pic].src = "../img/off1.jpg";
				}
				else if ( !(data.localeCompare("0")) ) {
					Buttons[pic].src = "../img/on1.jpg";
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
			else {
				//update the index pic für GPIO 26 und 27
				if ( !(data.localeCompare("0")) ){
					// so ist das Buttons[pic].src = "data/img/red/red_"+pic+".jpg"
					// Buttons[pic].src = "data/img/red/red.jpg";
					Buttons[pic].src = "../img/off1.jpg";
				}
				else if ( !(data.localeCompare("1")) ) {
					Buttons[pic].src = "../img/on1.jpg";
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
