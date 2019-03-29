	 <?php
	 // Daten fuer Autorefresh
    $page = $_SERVER['PHP_SELF'];
    $sec = "60";

	$version = "1.7 vom 20.04.2016";
	
	//Werte DS18B20
	$w1vorlauf =    "28-0000070347d8";
	$w1ruecklauf =  "28-00000703bf24";
	$w1solar =      "28-00000703f6c7";
	$w1outdoor =    "28-0000070401b2";
	$w1schuppen =   "28-00000703d304";

	// Auslesen CPU Temp
	$cputemp=file_get_contents("/sys/class/thermal/thermal_zone0/temp");
	$cputemp = sprintf("%2.0f", $cputemp / 1000);

	//Auslesen Boot Zeit Controller
	$boottime=file_get_contents('/var/www/html/boottime.txt');

	//Auslesen Laufzeit Pumpe in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO1.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$pumpentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Solarbypass  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO2.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$solartime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Reinigen  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO26.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$reinigentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Filtern  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO27.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$filtertime=$pumpstunde . "h " . $pumpminute ."m";

	//aktuelle Zeit
	$now =  date("d.m.Y  H:i");
	
	//Abfrage Sommer oder Winter Betrieb 0=Winter   1=Sommer
	exec ("gpio read 28", $summer, $return );

	//Lesen min max werte
	$poolmin=file_get_contents('/var/www/html/poolmin.txt');
	$poolmax=file_get_contents('/var/www/html/poolmax.txt');
	$poolnow=file_get_contents('/var/www/html/poolnow.txt');
	$temppool = sprintf("%2.0f", $poolnow);
	$ruecklaufmin=file_get_contents('/var/www/html/ruecklaufmin.txt');
	$ruecklaufmax=file_get_contents('/var/www/html/ruecklaufmax.txt');
	$ruecklaufnow=file_get_contents('/var/www/html/ruecklaufnow.txt');
	$tempruecklauf = sprintf("%2.0f", $ruecklaufnow);
	$solarmin=file_get_contents('/var/www/html/solarmin.txt');
	$solarmax=file_get_contents('/var/www/html/solarmax.txt');
	$solarnow=file_get_contents('/var/www/html/solarnow.txt');
	$tempsolar = sprintf("%2.0f", $solarnow);
	$outdoormin=file_get_contents('/var/www/html/outdoormin.txt');
	$outdoormax=file_get_contents('/var/www/html/outdoormax.txt');
	$outdoornow=file_get_contents('/var/www/html/outdoornow.txt');
	$tempoutdoor = sprintf("%2.0f", $outdoornow);
	$schuppenmin=file_get_contents('/var/www/html/schuppenmin.txt');
	$schuppenmax=file_get_contents('/var/www/html/schuppenmax.txt');
	$schuppennow=file_get_contents('/var/www/html/schuppennow.txt');
	$tempschuppen = sprintf("%2.0f", $schuppennow);	
	?>
