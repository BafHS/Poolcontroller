<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values
if (isset ( $_GET["url"] )) {
	$url = strip_tags ($_GET["url"]);
	//test if value is a number
	//reading pin's status
	$status = file_get_contents('http://'.$url.'/toggle');
	// Eintrag ins Log
	//showecho("esp.php","Normal","Change ESP $url auf Status $status");
	echo($status);
	
} //print fail if cannot use values
else { echo ("fail no get"); }


//Debug bzw Syslog Message
function showecho($job,$info,$text){
		//Open Connection to MySQL
		connectsql();
		// --- Write Data to DB ---
		$text=str_replace(chr(39),chr(34),$text);
		$sql_query = "insert into poollog (job,status,text) values ('$job','$info','$text')";
		mysql_query($sql_query) or syslog(LOG_WARNING,"** kein Schreiben durch $job in DB! **". mysql_error());
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