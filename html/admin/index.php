<?php  
	$sec = 60;
?>
<html>
	<head>
		<title>Knappe Cockpit  *ADMIN*</title>
		<link rel="stylesheet" type="text/css" href="../css/pool-style.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="shortcut icon" href="../img/favicon.ico" type="image/ico" />
		<link rel="icon" href="../img/favicon.ico" type="image/ico" />
		<script src="../script/jquery-2.2.0.min.js"></script> 
        <style type="text/css">
		</style>
        </head>
        <body>
        <center>
            <div class="thermometers">
				<div id="screen">
					<div class="header" ><b>*Adminboard in Schönow*</b> Status vom <?php echo $now;?></div>
					<div class="label" >Daten werden geladen.  Bitte warten <br /></div>

				</div>
				<div class="disclaimercenter" >Letzten 200 Log Einträge (Refresh 10 Sekunden) 
					<!--<input type='checkbox' name='Alle' id='loggingAll' /> Alle -->
					<input type='checkbox' name='Start' id='loggingStart' /><p style="color:#FFFFFF; background-color:#00ff00"> Start </p> 
					<input type='checkbox' name='Ende' id='loggingEnde' /><p style="color:#FFFFFF; background-color:#000000"> Ende </p> 
					<input type='checkbox' name='Normal' id='loggingNormal' /><p style="background-color:#01DFD7"> Normal </p> 
					<input type='checkbox' name='Info' id='loggingInfo' /><p style="background-color:#00FF00"> Info </p>
					<input type='checkbox' name='GPIO' id='loggingGPIO' /><p style="color:#FFFFFF; background-color:#990033"> GPIO </p>
					<input type='checkbox' name='Warnung' id='loggingWarnung' /><p style="background-color:#FE9A2E"> Warnung </p> 
					<input type='checkbox' name='Fehler' id='loggingFehler' /><p style="background-color:#FF0000"> Fehler </p></div>
			       	<ul class="Logging"></ul>
</div>
</center>

	<!-- javascript -->
	<script src="../script/scriptChangeBeregnung.js"></script>
	<script src="../script/scriptChangeBetriebsart.js"></script>
	<script src="../script/scriptGPIOFlipSwitch.js"></script>
	<script src="../script/scriptesp.js"></script>
	<script src="../script/scriptmasteroff.js"></script>
	<script type="text/javascript" src="logbuch.js"></script>
	<script>
	$(document).ready(function(){
		$("#screen").load('adminboard.php')
		setInterval(function(){
			$("#screen").load('adminboard.php')
	    }, <?php echo $sec*1000;?>);
	});
	</script>

	</body>
</html>

