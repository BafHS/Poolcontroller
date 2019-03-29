<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Familie Knappe</title>
<link rel="stylesheet" type="text/css" href="../css/pool-style.css" />
		<!--
		<script src="../script/jquery-2.1.3.min.js"></script> 
		!-->
<style type="text/css">
.auto-style1 {
	color: #FF0000;
}
</style>
</head>
<?php
$now =  date("d.m.Y  H:i");
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
	//Lesen min max werte
	$poolmin=file_get_contents('/var/www/html/poolmin.txt');
	$poolmax=file_get_contents('/var/www/html/poolmax.txt');
	$poolnow=file_get_contents('/var/www/html/poolnow.txt');
	$ruecklaufmin=file_get_contents('/var/www/html/ruecklaufmin.txt');
	$ruecklaufmax=file_get_contents('/var/www/html/ruecklaufmax.txt');
	$ruecklaufnow=file_get_contents('/var/www/html/ruecklaufnow.txt');
	$solarmin=file_get_contents('/var/www/html/solarmin.txt');
	$solarmax=file_get_contents('/var/www/html/solarmax.txt');
	$solarnow=file_get_contents('/var/www/html/solarnow.txt');
	$outdoormin=file_get_contents('/var/www/html/outdoormin.txt');
	$outdoormax=file_get_contents('/var/www/html/outdoormax.txt');
	$outdoornow=file_get_contents('/var/www/html/outdoornow.txt');
	$schuppennow=file_get_contents('/var/www/html/schuppennow.txt');

	exec ("gpio -g read 0", $pumpe, $return );
	exec ("gpio -g read 1", $solar, $return );
	exec ("gpio -g read 12", $summer, $return );

?>
<body>
<div class="thermometers">
<div class="disclaimer" >Status vom: <?php echo $now;?>   <?php
if ($summer[0] == 0 ) {
	echo ("<font color=0066ff>Anlage im Wintermodus</font>");
	}
if ($summer[0] == 1 ) {
	echo ("<font color=ff9900>Anlage im Sommermodus</font>");
	}
?>
<hr>
<table>
<tr>
<td>Pumpe</td>
<td>
<?php
if ($pumpe[0] == 1 ) {
	echo ("<font color=ff0000>AUS</font>");
	}
	//if on
if ($pumpe[0] == 0 ) {
	echo ("<font color=00ff00>EIN</font>");}

?>
</td>
<td>Laufzeit</td><td><?php echo $pumpentime;?></td>
<td>Solar</td><td><?php echo $solarnow;?>°</td>
<td>Solar<font color=4B4FFB>↓</font></td><td><?php echo $solarmin;?>°</td>
<td>Solar<font color=f40303>↑</font></td><td><?php echo $solarmax;?>°</td>
<td>Garten</td><td><?php echo $outdoornow;?>°</td>
</tr>
<tr>
<td>Solarbypass</td>
<td>
<?php
if ($solar[0] == 1 ) {
	echo ("<font color=ff0000>AUF</font>");
	}
	//if on
if ($solar[0] == 0 ) {
	echo ("<font color=00ff00>ZU</font>");}

?>
</td>
<td>Laufzeit</td><td><?php echo $solartime;?></td>
<td>Pool</td><td><?php echo $poolnow;?>°</td>
<td>Pool <font color=4B4FFB>↓</font></td><td><?php echo $poolmin;?>°</td>
<td>Pool <font color=f40303>↑</font></td><td><?php echo $poolmax;?>°</td>
<td>Schuppen</td><td><?php echo $schuppennow;?>°</td>
</tr>
</table>
</div>
</div>
</body>
</html>
