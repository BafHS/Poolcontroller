<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values
if (isset ( $_GET["pic"] )) {
	$pic = strip_tags ($_GET["pic"]);
	
	//test if value is a number
	if ( (is_numeric($pic)) && ($pic <= 28) && ($pic >= 0) ) {
		//set the gpio's mode to output		
		system("gpio -g mode ".$pic." out");
		//reading pin's status
		exec ("gpio -g read ".$pic, $status, $return );
		//set the gpio to high/low
		if ($status[0] == "0" ) { $status[0] = "1"; }
		else if ($status[0] == "1" ) { $status[0] = "0"; }
		// Eintrag ins Log
		showecho("gpio.php","Normal","Change GPIO -G PIN $pic auf Status $status[0]");
		system("gpio -g write ".$pic." ".$status[0] );
		//reading pin's status
		exec ("gpio -g read ".$pic, $status, $return );
		//print it to the client on the response
		echo($status[0]);
		
	}
	else { echo ("fail  Get"); }
} //print fail if cannot use values
else { echo ("fail no get"); }


//Debug bzw Syslog Message
function showecho($job,$info,$text){
		//Open Connection to MySQL
		connectsql();
		// --- Write Data to DB ---
		$text=str_replace(chr(39),chr(34),$text);
		$sql_query = "insert into poollog (job,status,text) values ('$job','$info','$text')";
		//am 26.04.2018 kein Log mehr
		//mysql_query($sql_query) or syslog(LOG_WARNING,"** kein Schreiben durch $job in DB! **". mysql_error());
		//Close Connection to MySQL
		mysql_close();
}
//Debug bzw Syslog Message
function connectsql(){
	$mysqlhost="localhost";
	$mysqluser="pool_insert";
	$mysqlpwd="poolinsert";
	$mysqldb="knappe";
		// --- Write Data to DB ---
		$connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or syslog(LOG_WARNING,"** Keine Verbindung zum Server! **". mysql_error());
		mysql_select_db($mysqldb, $connection) or syslog(LOG_WARNING,"** kein Select zur DB! ** **". mysql_error());
	
		//mit mysql_close wird die Verbindung geschlossen
}


?>