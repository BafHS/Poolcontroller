//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the flipswitch
var beregnungmorgens = document.getElementById("beregnungmorgens");
var beregnungmittags = document.getElementById("beregnungmittags");
var beregnungabends = document.getElementById("beregnungabends");
var dailypumpmittags = document.getElementById("dailypumpmittags");
var dailypumpabends = document.getElementById("dailypumpabends");
function change_beregnung ( pic ) {
   	var data = 0;
	var request = new XMLHttpRequest();
	request.open( "GET" , "../script/changeberegnung.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
				//update the index pic
				if ( !(data.localeCompare("on")) ){
					if ( !(pic("0")) ){
						beregnungmorgens.checked=true;
					}
					if ( !(pic("1")) ){
						beregnungmittags.checked=true;
					}
					if ( !(pic("2")) ){
						beregnungabends.checked=true;
					}
					if ( !(pic("3")) ){
						dailypumpmittags.checked=true;
					}
					if ( !(pic("4")) ){
						dailypumpabends.checked=true;
					}
				}
				else if ( !(data.localeCompare("off")) ) {
					if ( !(pic("0")) ){
						beregnungmorgens.checked=false;
					}
					if ( !(pic("1")) ){
						beregnungmittags.checked=false;
					}
					if ( !(pic("2")) ){
						beregnungabends.checked=false;
					}
					if ( !(pic("3")) ){
						dailypumpmittags.checked=false;
					}
					if ( !(pic("4")) ){
						dailypumpabends.checked=false;
					}
				}
				else if ( !(data.localeCompare("fail"))) {
					alert ("Prüfe das Script hier stimmt was nicht! data.localeCompare=fail" );
					return ("fail");			
				}
				else {
					alert ("Prüfe das Script hier stimmt was nicht! else fail" );
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
