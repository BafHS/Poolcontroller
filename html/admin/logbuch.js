$(document).ready( function() {
 updates(); 
 done();
});
 
function done() {
	  setTimeout( function() { 
	  updates(); 
	  done();
	  }, 10000);    //10 Sekunden 10 * 1000
}
 
function updates() {
		//var Alle=document.getElementById('loggingAll');
		var Start=document.getElementById('loggingStart');
		var Ende=document.getElementById('loggingEnde');
		var Normal=document.getElementById('loggingNormal');
		var Info=document.getElementById('loggingInfo');
		var GPIO=document.getElementById('loggingGPIO');
		var Warnung=document.getElementById('loggingWarnung');
		var Fehler=document.getElementById('loggingFehler');
		var suche = "";
		if (Start.checked) {
			if (suche.length == 0){
				suche = suche.concat("where status = 'Start'");
			} else {
				suche = suche.concat(" or status = 'Start'");
			}	
		} 
		if (Ende.checked) {
			if (suche.length == 0){
				suche = suche.concat("where status = 'Ende'");
			} else {
				suche = suche.concat(" or status = 'Ende'");
			}	
		} 
		if (Normal.checked) {
			if (suche.length == 0){
				suche = suche.concat("where status = 'Normal'");
			} else {
				suche = suche.concat(" or status = 'Normal'");
			}	
		} 
		if (Info.checked) {
			if (suche.length == 0){
				suche = suche.concat("where status = 'Info'");
			} else {
				suche = suche.concat(" or status = 'Info'");
			}	
		}
		if (GPIO.checked) {
			if (suche.length == 0){
				suche = suche.concat("where status = 'GPIO'");
			} else {
				suche = suche.concat(" or status = 'GPIO'");
			}	
		}
		if (Warnung.checked) {
			if (suche.length == 0){
				var suche="where status = 'Warnung'";
			} else {
				suche = suche.concat(" or status = 'Warnung'");
			}	
		} 
		if (Fehler.checked) {
			if (suche.length == 0){
				var suche="where status = 'Fehler'";
			} else {
				suche = suche.concat(" or status = 'Fehler'");
			}	
		}
/* 		if (Alle.checked) {
			suche = suche.concat("where status <> ''");
			Normal.checked=false;
			Info.checked=false;
			Warnung.checked=false;
			Fehler.checked=false;
		}
*/		//per default alles suchen
		if (suche.length == 0){
				suche = suche.concat('where status <> ""');
				suche = "";
			} 
	//$.getJSON("logbuchsqlneu.php", {was: "na was wohl", was1: "doppel was", suche: suche}, function(data) {
	$.getJSON("logbuchsql.php", {suche: suche}, function(data) {
	//$.getJSON(url, function(data){       
		$("ul").empty();
		$("ul").append("<table width=240>");
        //$("ul").append("<tr>");
	    //$("ul").append("<td>Datum: </td>"
	    //			  +"<td>Job:   </td>"
	    //			  +"<td>Kategorie: </td>"
	    //			  +"<td>Meldung: </td></tr>");
	    var zeile = false;
	   $.each(data.result, function(){
        $("ul").append("<tr>");
        			if (zeile == true) {
				      $("ul").append("<td  bgcolor='#bfbfbf' width='95'>"+this['Datum']+"</td>"
	    			  +"<td  bgcolor='#bfbfbf'  width='65'>"+this['Job']+"</td>");
	    			  $status = this['Status'];
	    			  if ($status == "Warnung") {
		    			  $("ul").append("<td bgcolor='#FE9A2E' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Info') {
		    			  $("ul").append("<td bgcolor='#00FF00' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'GPIO') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#990033' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Normal') {
		    			  $("ul").append("<td bgcolor='#01DFD7' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Fehler') {
		    			  $("ul").append("<td bgcolor='#FF0000' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Start') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#00ff00' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Ende') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#000000' width='30'>"+this['Status']+"</td>");
		    		  }else 					  {
		    			  $("ul").append("<td  bgcolor='#bfbfbf'  width='30' >"+this['Status']+"</td>");
					  }
	    			  $("ul").append("<td  bgcolor='#bfbfbf' >"+this['Bemerkung']+"</td>");
	    			   zeile = false;
        			}
        			else {
				      $("ul").append("<td width='95'>"+this['Datum']+"</td>"
	    			  +"<td width='65'>"+this['Job']+"</td>");
	    			  $status = this['Status'];
	    			  if ($status == "Warnung") {
		    			  $("ul").append("<td bgcolor='#FE9A2E' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Info') {
		    			  $("ul").append("<td bgcolor='#00FF00' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'GPIO') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#990033' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Normal') {
		    			  $("ul").append("<td bgcolor='#01DFD7' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Fehler') {
		    			  $("ul").append("<td bgcolor='#FF0000' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Start') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#00ff00' width='30'>"+this['Status']+"</td>");
					  } else if ($status == 'Ende') {
		    			  $("ul").append("<td style='color:#FFFFFF; background-color:#000000'  width='30'>"+this['Status']+"</td>");
		    		  }else 					  {
		    			  $("ul").append("<td width='30' >"+this['Status']+"</td>");
					  }
	    			  $("ul").append("<td>"+this['Bemerkung']+"</td>");
	    			   zeile = true;
        			}
        $("ul").append("</tr>");
	   });
       $("ul").append("</table>");
 })
	.fail(function( jqxhr, textStatus, error ) {
   var err = suche + " " + textStatus + ", " + error;
   console.log( "Request Failed: " + err );
});
}
