<?php
//Debug bzw Syslog Message
function read_summer(){
		//Open Connection to MySQL
		connectsql();
		// --- Select Data from DB ---
		$sql_query = "SELECT summer1 FROM poolsettings";
		$result= mysql_query($sql_query) or syslog(LOG_WARNING,"** kein Schreiben durch $job in DB! **". mysql_error());
		// Ergebniss in Variable
		$value = mysql_fetch_object($result); 
		$summer1 = $value->summer1;
		//echo "Betriebsart   $summer1 ";
		//Close Connection to MySQL
		mysql_close();
		return $summer1; 
}
function change_summer($betriebsart){
		//Open Connection to MySQL
		connectsql();
		// --- Write Data to DB ---
		$sql_query = "UPDATE poolsettings SET `summer1`=$betriebsart";
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
$job = basename(__FILE__);

$betriebsart =read_summer();
//echo "Betriebsart   $betriebsart ";
//Abfrage summer
if($betriebsart == 1){
   // SOMMER change to WINTER
		change_summer(0);
		echo 0;
		//echo "SOMMER change to WINTER";
   } else{
   // WINTER change to SOMMER
		change_summer(1);
		echo 1;
		//echo "WINTER change to SOMMER"; 
   }
?>
