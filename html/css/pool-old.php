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

	//Auslesen Pool (Vorlauf)
	$temppath = "/sys/bus/w1/devices/$w1vorlauf/w1_slave";
	$tempSensorRawData = implode('', file($temppath));
	$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
	$temppool = sprintf("%2.0f", $tempSensorTemperature / 1000);

	//Auslesen Pool (Ruecklauf)
	$temppath = "/sys/bus/w1/devices/$w1ruecklauf/w1_slave";
	$tempSensorRawData = implode('', file($temppath));
	$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
	$tempruecklauf  = sprintf("%2.0f", $tempSensorTemperature / 1000);

	//Auslesen Solar
	$temppath = "/sys/bus/w1/devices/$w1solar/w1_slave";
	$tempSensorRawData = implode('', file($temppath));
	$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
	$tempsolar = sprintf("%2.0f", $tempSensorTemperature / 1000);
	
	//Auslesen outdoor
	$temppath = "/sys/bus/w1/devices/$w1outdoor/w1_slave";
	$tempSensorRawData = implode('', file($temppath));
	$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
	$tempoutdoor = sprintf("%2.0f", $tempSensorTemperature / 1000);

	//Auslesen Schuppen
	$temppath = "/sys/bus/w1/devices/$w1schuppen/w1_slave";
	$tempSensorRawData = implode('', file($temppath));
	$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
	$tempschuppen = sprintf("%2.0f", ($tempSensorTemperature / 1000));

	//aktuelle Zeit
	$now =  date("d.m.Y  H:i");
	
	//Abfrage Sommer oder Winter Betrieb 0=Winter   1=Sommer
	exec ("gpio read 28", $summer, $return );

	//Lesen min max werte
	$poolmin=file_get_contents('/var/www/html/poolmin.txt');
	$poolmax=file_get_contents('/var/www/html/poolmax.txt');
	$ruecklaufmin=file_get_contents('/var/www/html/ruecklaufmin.txt');
	$ruecklaufmax=file_get_contents('/var/www/html/ruecklaufmax.txt');
	$solarmin=file_get_contents('/var/www/html/solarmin.txt');
	$solarmax=file_get_contents('/var/www/html/solarmax.txt');
	$outdoormin=file_get_contents('/var/www/html/outdoormin.txt');
	$outdoormax=file_get_contents('/var/www/html/outdoormax.txt');
	$schuppenmin=file_get_contents('/var/www/html/schuppenmin.txt');
	$schuppenmax=file_get_contents('/var/www/html/schuppenmax.txt');
	
	?>
