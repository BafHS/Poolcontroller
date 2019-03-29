//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the flipswitch
var summerwinterswitch = document.getElementById("summerwinterswitch");
function change_betriebsart ( pic ) {
      // $.ajax({
        // type: "POST",
        // url: "../script/changesummer.php",
        // //data: { name: $("select[name='players']").val()},
        // success:function( msg ) {
         // alert( "Data Saved: " + msg );
        // }
       // });
   	var data = 0;
	var request = new XMLHttpRequest();
	request.open( "GET" , "../script/changesummer.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
				//update the index pic
				if ( !(data.localeCompare("1")) ){
					summerwinterswitch.checked=false;
				}
				else if ( !(data.localeCompare("0")) ) {
					summerwinterswitch.checked=true;
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
