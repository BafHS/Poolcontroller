	 <?php
	 // Daten für Autorefresh
    $page = $_SERVER['PHP_SELF'];
    $sec = "60";

	$version = "1.6 vom 13.03.2016";
	
	// Auslesen CPU Temp
	$cputemp=file_get_contents("/sys/class/thermal/thermal_zone0/temp");
	$cputemp = sprintf("%2.0f", $cputemp / 1000);

	//Auslesen Boot Zeit Controller
	$boottime=file_get_contents('/var/www/html/boottime.txt');

	//aktuelle Zeit
	$now =  date("d.m.Y  H:i");
	
	?>
