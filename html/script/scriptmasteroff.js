//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the flipswitch
var flipswitch_0 = document.getElementById("flipswitch_0");
var flipswitch_1 = document.getElementById("flipswitch_1");
var flipswitch_2 = document.getElementById("flipswitch_2");
var flipswitch_3 = document.getElementById("flipswitch_3");
var flipswitch_4 = document.getElementById("flipswitch_4");
var flipswitch_5 = document.getElementById("flipswitch_5");
var flipswitch_6 = document.getElementById("flipswitch_6");
var flipswitch_7 = document.getElementById("flipswitch_7");
var flipswitch_8 = document.getElementById("flipswitch_8");
var flipswitch_9 = document.getElementById("flipswitch_9");
var flipswitch_10 = document.getElementById("flipswitch_10");
var flipswitch_11 = document.getElementById("flipswitch_11");
var flipswitch_12 = document.getElementById("flipswitch_12");
var flipswitch_13 = document.getElementById("flipswitch_13");
var flipswitch_14 = document.getElementById("flipswitch_14");
var flipswitch_15 = document.getElementById("flipswitch_15");
var flipswitch_16 = document.getElementById("flipswitch_16");
var flipswitch_17 = document.getElementById("flipswitch_17");
var flipswitch_18 = document.getElementById("flipswitch_18");
var flipswitch_19 = document.getElementById("flipswitch_19");
var flipswitch_20 = document.getElementById("flipswitch_20");
var flipswitch_21 = document.getElementById("flipswitch_21");
var flipswitch_22 = document.getElementById("flipswitch_22");
var flipswitch_23 = document.getElementById("flipswitch_23");
var flipswitch_24 = document.getElementById("flipswitch_24");
var flipswitch_25 = document.getElementById("flipswitch_25");
var flipswitch_26 = document.getElementById("flipswitch_26");
var flipswitch_27 = document.getElementById("flipswitch_27");
var flipswitch_28 = document.getElementById("flipswitch_28");
var flipswitch_29 = document.getElementById("flipswitch_29");
var flipswitch_99 = document.getElementById("flipswitch_99");
var summerwinterswitch = document.getElementById("summerwinterswitch");

//Create an array for easy access later
var Buttons = [ flipswitch_0, flipswitch_1, flipswitch_2, flipswitch_3, flipswitch_4, flipswitch_5, flipswitch_6, flipswitch_7, flipswitch_8, flipswitch_9, flipswitch_10, flipswitch_11, flipswitch_12, flipswitch_13, flipswitch_14, flipswitch_15, flipswitch_16, flipswitch_17, flipswitch_18, flipswitch_19, flipswitch_20, flipswitch_21, flipswitch_22, flipswitch_23, flipswitch_24, flipswitch_25, flipswitch_26, flipswitch_27, flipswitch_28, flipswitch_29, flipswitch_99];

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function masterOFF ( pic ){
	var request = new XMLHttpRequest();
	request.open( "GET" , "../script/gpiomasteroff.php?pic=" + pic, true);
	request.send(null);
	document.getElementById("flipswitch_2").checked = false;
	document.getElementById("flipswitch_3").checked = false;
	document.getElementById("flipswitch_4").checked = false;
	document.getElementById("flipswitch_7").checked = false;
	document.getElementById("esp_0").checked = false;
	document.getElementById("esp_1").checked = false;
	//setze MasterOFF wieder auf aus
	document.getElementById("flipswitch_99").checked = false;

return 0;
}