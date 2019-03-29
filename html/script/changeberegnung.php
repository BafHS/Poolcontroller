<?php
//einlesen der Daten
$beregnungmorgens=file_get_contents('/var/www/html/beregnungmorgens.txt');
$beregnungmittags=file_get_contents('/var/www/html/beregnungmittags.txt');
$beregnungabends=file_get_contents('/var/www/html/beregnungabends.txt');
$dailypumpmittags=file_get_contents('/var/www/html/dailypumpmittags.txt');
$dailypumpabends=file_get_contents('/var/www/html/dailypumpabends.txt');
//morgens PIC=0
//abends PIC=1
//auslesen Parameter
$pic = strip_tags ($_GET["pic"]);

//echo "Betriebsart   $betriebsart ";
//Abfrage summer
//echo("Pic=".$pic);
//echo("dailypumpabends=".$dailypumpabends);


//Morgens
if($pic == 0){
	// Morgens
	if ($beregnungmorgens == "on") {
		file_put_contents('/var/www/html/beregnungmorgens.txt','off') or print_r(error_get_last());
		$status = "off";
	};
	if ($beregnungmorgens == "off") {
		file_put_contents('/var/www/html/beregnungmorgens.txt','on') or print_r(error_get_last());
		$status = "on";
	};
   }
//Mittags
if($pic == 1){
	// Mittags
	if ($beregnungmittags == "on") {
		file_put_contents('/var/www/html/beregnungmittags.txt','off') or print_r(error_get_last());
		$status = "off";
		};
	if ($beregnungmittags == "off") {
		file_put_contents('/var/www/html/beregnungmittags.txt','on') or print_r(error_get_last());
		$status = "on";
		};
   }
//Abends
if($pic == 2){
	// Morgens
	if ($beregnungabends == "on") {
		file_put_contents('/var/www/html/beregnungabends.txt','off') or print_r(error_get_last());
		$status = "off";
	};
	if ($beregnungabends == "off") {
		file_put_contents('/var/www/html/beregnungabends.txt','on') or print_r(error_get_last());
		$status = "on";
	};
   }
//Daily Pump Mittags
if($pic == 3){
	// Mittags
	if ($dailypumpmittags == "on") {
		file_put_contents('/var/www/html/dailypumpmittags.txt','off') or print_r(error_get_last());
		$status = "off";
	};
	if ($dailypumpmittags == "off") {
		file_put_contents('/var/www/html/dailypumpmittags.txt','on') or print_r(error_get_last());
		$status = "on";
	};
	}
//Dailypump Abends
if($pic == 4){
	// Abends
	if ($dailypumpabends == "on") {
		file_put_contents('/var/www/html/dailypumpabends.txt','off') or print_r(error_get_last());
		$status = "off";
	};
	if ($dailypumpabends == "off") {
		file_put_contents('/var/www/html/dailypumpabends.txt','on') or print_r(error_get_last());
		$status = "on";
	};
   }


echo($status);

   ?>
