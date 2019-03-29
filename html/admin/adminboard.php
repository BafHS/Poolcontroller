<?php 
	 // Daten fuer Autorefresh
    $page = $_SERVER['PHP_SELF'];
    $sec = "60";

	$version = "2.9 vom 03.01.2019";
	
	// Auslesen CPU Temp
	$cputemp=file_get_contents("/sys/class/thermal/thermal_zone0/temp");
	$cputemp = sprintf("%2.0f", $cputemp / 1000);
	
	$alertinfo="CPU Wert = ".$cputemp;
	
	//Auslesen ESP
	$esp_ip = array("sonoffterrasse","SonOffschuppen","192.168.10.63");
	//Abfrage Status der ESP Schalter 1, 2, 3, 4
	$esp_array = array("off","off","off");
	for ( $i= 0; $i<2; $i++) {
		$esp_array[$i]=file_get_contents("http://".$esp_ip[$i]."/status");
	};

	
	//Auslesen CPU LOad
	$temp=sys_getloadavg();
	$cpuload=$temp[0];
	//Auslesen Boot Zeit Controller
	$boottime=file_get_contents('/var/www/html/boottime.txt');

	//Auslesen Beregnung Morgens aktiv
	$beregnungmorgens=file_get_contents('/var/www/html/beregnungmorgens.txt');
	$beregnungmittags=file_get_contents('/var/www/html/beregnungmittags.txt');
	$beregnungabends=file_get_contents('/var/www/html/beregnungabends.txt');

	//Auslesen tägliches Pumpen Mittags und Abends
	$dailypumpmittags=file_get_contents('/var/www/html/dailypumpmittags.txt');
	$dailypumpabends=file_get_contents('/var/www/html/dailypumpabends.txt');

	//Auslesen Druck Kanal 0
	$channel0=file_get_contents('/var/www/html/Kanal0.txt');
	$channel0max=file_get_contents('/var/www/html/Kanal0max.txt');
	//Auslesen Druck Kanal 1
	$channel1=file_get_contents('/var/www/html/Kanal1.txt');
	$channel1max=file_get_contents('/var/www/html/Kanal1max.txt');
	//Auslesen Druck Kanal 2
	$channel2=file_get_contents('/var/www/html/Kanal2.txt');
	$channel2max=file_get_contents('/var/www/html/Kanal2max.txt');
	//Auslesen Druck Kanal 3
	$channel3=file_get_contents('/var/www/html/Kanal3.txt');
	$channel3max=file_get_contents('/var/www/html/Kanal3max.txt');
	//Auslesen Druck Kanal 4
	$channel4=file_get_contents('/var/www/html/Kanal4.txt');
	$channel4max=file_get_contents('/var/www/html/Kanal4max.txt');
	//Auslesen Druck Kanal 5
	$channel5=file_get_contents('/var/www/html/Kanal5.txt');
	$channel5max=file_get_contents('/var/www/html/Kanal5max.txt');
	//Auslesen Druck Kanal 6
	$channel6=file_get_contents('/var/www/html/Kanal6.txt');
	$channel6max=file_get_contents('/var/www/html/Kanal6max.txt');

	//Auslesen Aktiver Kreislauf
	$kreislauf=file_get_contents('/var/www/html/Kreislauf.txt');

	//Auslesen Laufzeit Pumpe in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO0.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$pumpentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Solarbypass  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO1.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$solartime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit UWS  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO2.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$uwstime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenspot  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO3.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenspottime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenlampe  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO7.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenlampetime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenlampe  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO7.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$schaukeltime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenpumpe  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO5.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenpumpetime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Beregnung  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO6.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$beregnungtime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Reinigen  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO13.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$reinigentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Filtern  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO14.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$filtertime=$pumpstunde . "h " . $pumpminute ."m";

	//Pflanzensensor
	//Auslesen Bodenfeuchte
	$bodenfeuchte=file_get_contents('/var/www/html/bodenfeuchte.txt');
	$bodenfeuchtemax=file_get_contents('/var/www/html/bodenfeuchtemax.txt');
	$bodenfeuchtemin=file_get_contents('/var/www/html/bodenfeuchtemin.txt');
	//Auslesen battery
	$battery=file_get_contents('/var/www/html/battery.txt');
	//Auslesen sunlight
	$sunlight=file_get_contents('/var/www/html/sunlight.txt');
	//Auslesen fertility
	$fertility=file_get_contents('/var/www/html/fertility.txt');
	$fertilitymax=file_get_contents('/var/www/html/fertilitymax.txt');
	$fertilitymin=file_get_contents('/var/www/html/fertilitymin.txt');

	//aktuelle Zeit
	$now =  date("d.m.Y  H:i");
	
	//Abfrage Sommer oder Winter Betrieb 0=Winter   1=Sommer
	exec ("gpio -g read 12", $summer, $return );
	if ($summer[0] == 0){$modus= "Winter";}
	else {$modus= "Sommer";}
	//Abfrage Sommer oder Winter Betrieb 0=Winter   1=Sommer
	exec ("gpio -g read 27", $summerberegnung, $return );
	if ($summerberegnung[0] == 0){$modusberegnung= "Winter";}
	else {$modusberegnung= "Sommer";}

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



		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <center>
			<table class="rahmen">
        		<tr>
        	        <td colspan="10">
                         <div class="labelswitch" ><b>*Adminboard in Schönow*</b> Status vom <?php echo $now;?></div>
        	        </td>
        		</tr>
				<tr>
					<td colspan="10">
						<div class="labelswitch" >Temperaturen</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"class="responsiveCell">
						<div class="labelswitch" >Pool Vorlauf</div>
                    	<div class="labelswitch" ><?php  echo $temppool;?><strong>°</strong></div>
						<div class="minmax"><font color=4B4FFB>&dArr;</font><?php echo $poolmin;?>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=f40303>&uArr;</font><?php echo $poolmax;?>°</div>
					</td>
					<td colspan="2" class="responsiveCell">
						<div class="labelswitch" >Pool Rücklauf</div>
                    	<div class="labelswitch" ><?php  echo $tempruecklauf;?><strong>°</strong></div>
						<div class="minmax"><font color=4B4FFB>&dArr;</font><?php echo $ruecklaufmin;?>°&nbsp;<font color=f40303>&uArr;</font><?php echo $ruecklaufmax;?>°</div>
					</td>
					<td colspan="2">
						<div class="labelswitch" >Solar</div>
                    	<div class="labelswitch" ><?php  echo $tempsolar;?><strong>°</strong></div>
						<div class="minmax"><font color=4B4FFB>&dArr;</font><?php echo $solarmin;?>°&nbsp;<font color=f40303>&uArr;</font><?php echo $solarmax;?>°</div>
					</td>
					<td colspan="2">
						<div class="labelswitch" >Garten</div>
                    	<div class="labelswitch" ><?php  echo $tempoutdoor;?><strong>°</strong></div>
						<div class="minmax"><font color=4B4FFB>&dArr;</font><?php echo $outdoormin;?>°&nbsp;<font color=f40303>&uArr;</font><?php echo $outdoormax;?>°</div>
					</td>
					<td colspan="2">
						<div class="labelswitch" >Schuppen</div>
                    	<div class="labelswitch" ><?php  echo $tempschuppen;?><strong>°</strong></div>
						<div class="minmax"><font color=4B4FFB>&dArr;</font><?php echo $schuppenmin;?>°&nbsp;<font color=f40303>&uArr;</font><?php echo $schuppenmax;?>°</div>
					</td>
				</tr>
			</table>
			<table class="rahmen">
				<tr>
					<td colspan="3">
						<div class="labelswitch" >Solarsteuerung</div>
					</td>
					<td colspan="3">
						<div class="labelswitch" >Pumpe Druck <?php echo ($channel6." Bar <font color=f40303>&uArr;</font>".$channel6max." Bar ");?></div>
					</td>
				</tr>
				<?php
						/*Pin 
						0	Poolpumpe
						1	Solarbypass
						2	UWS
						3	Gartenlampe
						4	Spot
						5	Wasserpumpe
						6	Magnetventil
						7	Schaukel
						12	Sommer
						13	reinigen
						14	filtern
						24	automatic
						26  Automaticregner
						*/
						//Abfrage Status der GPIO Pins 0, 1, 2, 3, 4
						$val_array = array(0,0,0,0,0,0,0,0,0);
						for ( $i= 0; $i<8; $i++) {
							//system("gpio -g mode ".$i." out");
							exec ("gpio -g read ".$i, $val_array[$i], $return );
						};
						//Abfrage Status der GPIO Pins  12, 13 ,14
						$val_array1 = array(0,0,0);
						for ( $i= 13; $i<15; $i++) {
							//system("gpio -g mode ".$i." out");
							exec ("gpio -g read ".$i, $val_array1[$i], $return );
						};
						//Abfrage Automatic oder Manuell Betrieb Pool 0=manuell   1=Automatic
						exec ("gpio -g read 24", $automatic, $return );
						//Automatic
						// 1 = EIN   0=AUS  
							echo ("<td><div class='labelswitch'>Steuerung</div><div class='onoffswitch'>");
							if ($summer[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								//Manuell
								$i = 24;
								if ($automatic[0] == 0 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
									}
								//Automatic
								if ($automatic[0] == 1 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
									}
								echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								if ($automatic[0] == 1 ) {
									echo ("Automatik</div></td>\n");	 
								} 
								else {
									echo ("Manuell</div></td>\n");	 
								}
							};	 
						//for loop  Pumpe, Solar nur Anzeige und Winterbetrieb
						// 0 = EIN   1=AUS  wegen Relaisplatte
							for ($i = 0; $i < 2; $i++) {
								if ($i == 0) {echo ("<td><div class='labelswitch'>Pumpe</div><div class='onoffswitch'>");};
								if ($i == 1) {echo ("<td><div class='labelswitch'>Solarbypass</div><div class='onoffswitch'>");};
								if ($summer[0] == 0){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//AUS
									if ($val_array[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
										}
									//EIN
									if ($val_array[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_pin (".$i.")'  id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 0) {echo ("<div class='minmax'>".$pumpentime."</div></td>\n");};
									if ($i == 1) {echo ("<div class='minmax'>".$solartime."</div></td>\n");};
								};	 
							};	 
						//Reinigen Anzeige und Winterbetrieb
						// 1 = EIN   0=AUS
						//ist Reinigen notwendig??? kann man auch Filtern nehmen!
							for ($i = 13; $i < 14; $i++) {
								if ($i == 13) {echo ("<td><div class='labelswitch'>Reinigen</div><div class='onoffswitch'>");};
								if ($summer[0] == 0){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//AUS
									if ($val_array1[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
										}
									//EIN
									if ($val_array1[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_pin (".$i.")'  id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 13) {echo ("<div class='minmax'>".$reinigentime."</div></td>\n");};
								};	 
							};	 
						//daily pump Mittags aktiv siehe Datein /var/www/html/dailypumpmittags.txt
						// on = EIN   off=AUS  
							echo ("<td><div class='labelswitch'>Mittags</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								if ($dailypumpmittags == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_beregnung (3)' id='dailypumpmittags'/>");	}
								if ($dailypumpmittags == "on") {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_beregnung (3)' id='dailypumpmittags'/>");
									}
								echo ("<label class='onoffswitch-label' for='dailypumpmittags' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								echo ("12:00 Uhr</div></td>\n");	 
							};
						//daily pump Abends aktiv siehe Datein /var/www/html/dailypumpabends.txt
						// on = EIN   off=AUS  
							echo ("<td><div class='labelswitch'>Abends</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								if ($dailypumpabends == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_beregnung (4)' id='dailypumpabends'/>");	}
								if ($dailypumpabends == "on") {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_beregnung (4)' id='dailypumpabends'/>");
									}
								echo ("<label class='onoffswitch-label' for='dailypumpabends' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								echo ("19:00 Uhr</div></td>\n");	 
							};
							?>
					</tr>
					</table>
					<table class="Rahmen">
						<tr>
							<td colspan=6>
								<div class="labelswitch" >Beregnung</div>
							</td>
						</tr>
						<tr>
							<td class="responsiveCell">
								<?php
								if (($kreislauf == 1 ) and ($val_array[6][0] == 0 )){
									echo("<div class='labelswitch' >Kreislauf 1 <font color=2AFA06>Ein</font></div>");}
								else {
									echo("<div class='labelswitch' >Kreislauf 1 <font color=f40303>Aus</font></div>");}
								?>
								<div class="minmax" ><?php  echo $channel1;?> <font color=f40303>&uArr;</font><?php  echo $channel1max;?> Bar</div>
							</td>
							<td >
								<?php
								if (($kreislauf == 2)  and ($val_array[6][0] == 0 )){
									echo("<div class='labelswitch' >Kreislauf 2 <font color=2AFA06>Ein</font></div>");}
								else {
									echo("<div class='labelswitch' >Kreislauf 2 <font color=f40303>Aus</font></div>");}
								?>
								<div class="minmax" ><?php  echo $channel2;?> <font color=f40303>&uArr;</font><?php  echo $channel2max;?> Bar</div>
							</td>
							<td>
								<?php
								if (($kreislauf == 3) and ($val_array[6][0] == 0 )) {
									echo("<div class='labelswitch' >Kreislauf 3 <font color=2AFA06>Ein</font></div>");}
								else {
									echo("<div class='labelswitch' >Kreislauf 3 <font color=f40303>Aus</font></div>");}
								?>
								<div class="minmax" ><?php  echo $channel3;?> <font color=f40303>&uArr;</font><?php  echo $channel3max;?> Bar</div>
							</td>
							<td>
								<?php
								if (($kreislauf == 4) and ($val_array[6][0] == 0 )) {
									echo("<div class='labelswitch' >Kreislauf 4 <font color=2AFA06>Ein</font></div>");}
								else {
									echo("<div class='labelswitch' >Kreislauf 4 <font color=f40303>Aus</font></div>");}
								?>
								<div class="minmax" ><?php  echo $channel4;?> <font color=f40303>&uArr;</font><?php  echo $channel4max;?> Bar</div>
							</td>
							<?php
						//Abfrage Automatic oder Manuell Betrieb Regner 0=manuell   1=Automatic
						exec ("gpio -g read 26", $automaticregner, $return );
						//Automatic
						// 1 = EIN   0=AUS  
							echo ("<td><div class='labelswitch'>Steuerung</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								//Manuell
								$i = 26;
								if ($automaticregner[0] == 0 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
									}
								//Automatic
								if ($automaticregner[0] == 1 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
									}
								echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								if ($automaticregner[0] == 0 ) {
									echo ("Manuell</div></td>\n");
									}
								//Automatic
								if ($automaticregner[0] == 1 ) {
									echo ("Automatik</div></td>\n");
								}
									 
							};	 
						//Relais Gartenpumpe und Magnetventil
						// 0 = EIN   1=AUS
							for ( $i= 6; $i<7; $i++) {
								if ($i == 5) {echo ("<td><div class='labelswitch'>Pumpe</div><div class='onoffswitch'>");};
								if ($i == 6) {echo ("<td><div class='labelswitch'>Magnetventil</div><div class='onoffswitch'>");};
								if ($summerberegnung[0] == 0){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//AUS
									if ($val_array[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
										}
									//EIN
									if ($val_array[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_pin (".$i.")' id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 5) {echo ("<div class='minmax'>".$gartenpumpetime."</div></td>\n");};
									if ($i == 6) {echo ("<div class='minmax'>".$beregnungtime."</div></td>\n");};
								};	 
							};
							?>
						</tr>
						<tr>
							<td colspan=1>
								<div class="labelswitch" >Beregnung</div>
								</td>
							<td colspan=2>
								<div class="labelswitch" >Bodensensor</div>
								</td>
							<td colspan=3>
								<div class="labelswitch" >Beregnung Zeit</div>
								</td>
						</tr>
						<tr>
							<td class="responsiveCell">
								<div class="labelswitch" >Zulauf</div>
								<div class="minmax" ><?php  echo $channel0;?> <font color=f40303>&uArr;</font><?php  echo $channel0max;?> Bar</div>
							</td>
							<td>
								<div class="labelswitch" >Feuchtigkeit</div>
								<div class="minmax" ><?php  echo $bodenfeuchte;?> % <font color=4B4FFB>&dArr;</font><?php echo $bodenfeuchtemin;?>%&nbsp;<font color=f40303>&uArr;</font><?php echo $bodenfeuchtemax;?>%</div>
								</td>
							<td>
								<div class="labelswitch" >Helligkeit</div>
								<div class="minmax" ><?php  echo $sunlight;?> Lux</div>
							</td>
						<?php
						//Beregnungs morgens aktiv siehe Datein /var/www/html/beregnungmorgens.txt
						// on = EIN   off=AUS  
							echo ("<td><div class='labelswitch'>Morgens</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								if ($beregnungmorgens == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_beregnung (0)' id='beregnungmorgens'/>");	}
								if ($beregnungmorgens == "on") {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_beregnung (0)' id='beregnungmorgens'/>");
									}
								echo ("<label class='onoffswitch-label' for='beregnungmorgens' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								echo ("6:00 Uhr</div></td>\n");	 
							};
						//Beregnungs morgens aktiv siehe Datein /var/www/html/beregnungmittags.txt
						// on = EIN   off=AUS  
							echo ("<td><div class='labelswitch'>Mittags</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								if ($beregnungmittags == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_beregnung (1)' id='beregnungmittags'/>");	}
								if ($beregnungmittags == "on") {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_beregnung (1)' id='beregnungmittags'/>");
									}
								echo ("<label class='onoffswitch-label' for='beregnungmittags' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								echo ("12:00 Uhr</div></td>\n");	 
							};
						//Beregnungs morgens aktiv siehe Datein /var/www/html/beregnungabends.txt
						// on = EIN   off=AUS  
							echo ("<td><div class='labelswitch'>Abends</div><div class='onoffswitch'>");
							if ($summerberegnung[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								if ($beregnungabends == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' onclick='change_beregnung (2)' id='beregnungabends'/>");
									}
								if ($beregnungabends == "on") {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' onclick='change_beregnung (2)' id='beregnungabends'/>");
									}
								echo ("<label class='onoffswitch-label' for='beregnungabends' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='minmax'>");
								echo ("18:00 Uhr</div></td>\n");	 
							};?>

							<?php
							// //für die Automatic Beregnung / Pool
							// <td>
								// <div class='labelswitch'>Pool</div>
								// <div class="summerwinterswitch">
									// <?php
									// if ($summer[0] == 0 ){
										// echo ("<input type='checkbox' name='betrieb' class='summerwinterswitch-checkbox' id='summerwinterswitch_pool'  autocomplete='off' checked='checked' disabled='disabled'>");
									// }
									// else{
										// echo ("<input type='checkbox' name='betrieb' class='summerwinterswitch-checkbox' id='summerwinterswitch_pool'  autocomplete='off' disabled='disabled'>");
										
									// }
									// ?>	
									<?php
									// <label class="summerwinterswitch-label" for="summerwinterswitch_pool" enableviewstate="true" >
										// <span class="summerwinterswitch-inner"></span>
										// <span class="summerwinterswitch-switch"></span>
									// </label>
								// </div>
							// </td>
							// <td>
								// <div class='labelswitch'>Beregnung</div>
								// <div class="summerwinterswitch">
									// <?php
									// if ($summerberegnung[0] == 0 ){
										// echo ("<input type='checkbox' name='betrieb' class='summerwinterswitch-checkbox' id='summerwinterswitch_beregnung' autocomplete='off' checked='checked' disabled='disabled'>");
									// }
									// else{
										// echo ("<input type='checkbox' name='betrieb' class='summerwinterswitch-checkbox' id='summerwinterswitch_beregnung' autocomplete='off' disabled='disabled'>");
										
									// }
									// ?>	
									<?php
									// <label class="summerwinterswitch-label" for="summerwinterswitch_beregnung" enableviewstate="true" >
										// <span class="summerwinterswitch-inner"></span>
										// <span class="summerwinterswitch-switch"></span>
									// </label>
								// </div>
							// </td>
							?>
						</tr>
					</table>
					<table class="Rahmen">
					<tr>
						<td colspan=6>
							<div class="labelswitch" >Beleuchtung</div>
						</td>
					</tr>
					<tr>
						<?php
						//for loop ESP Schalter
						// 0 = EIN   1=AUS  wegen Relaisplatte inklusive Schalten
							for ($i = 0; $i < 1; $i++) {
								if ($i == 0) {echo ("<td><div class='labelswitch'>Test</div><div class='onoffswitch'>");};
								//AUS
								if ($esp_array[$i] == "off" ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='esp_".$i."' onclick='change_esp (".$i.",\"".$esp_ip[$i]."\")'/>");
									}
								//EIN
								else {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' id='esp_".$i."' onclick='change_esp (".$i.",\"".$esp_ip[$i]."\")'/>");
									}
								echo ("<label class='onoffswitch-label' for='esp_".$i."' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label></div>");
								if ($i == 0) {echo ("<div class='minmax'>Test</div></td>\n");};
							};	 

						//for loop UWS, Gartensport und Gartenlampe  Schalten und Winterbetrieb
							// 0 = EIN   1=AUS  wegen Relaisplatte inklusive Schalten
								for ($i = 2; $i < 5; $i++) {
									if ($i == 2) {echo ("<td><div class='labelswitch'>UWS</div><div class='onoffswitch'>");};
									if ($i == 3) {echo ("<td><div class='labelswitch'>Kugellampe</div><div class='onoffswitch'>");};
									if ($i == 4) {echo ("<td><div class='labelswitch'>Gartenspot</div><div class='onoffswitch'>");};
									if ($summer[0] == 0 && $i == 2){
											echo ("<img id='button_".$i."' src='../img/wintermode.png'");
											echo ("</div></td>\n");
										}
									else {
										//AUS
										if ($val_array[$i][0] == 1 ) {
											echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='flipswitch_".$i."' onclick='change_pin (".$i.")'/>");
											}
										//EIN
										if ($val_array[$i][0] == 0 ) {
											echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' id='flipswitch_".$i."' onclick='change_pin (".$i.")'/>");
											}
										echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
										echo ("<span class='onoffswitch-inner'></span>");
										echo ("<span class='onoffswitch-switch'></span>");
										echo ("</label></div>");
										if ($i == 2) {echo ("<div class='minmax'>".$uwstime."</div></td>\n");};
										if ($i == 3) {echo ("<div class='minmax'>".$gartenspottime."</div></td>\n");};
										if ($i == 4) {echo ("<div class='minmax'>".$gartenlampetime."</div></td>\n");};
										if ($i == 7) {echo ("<div class='minmax'>".$schaukeltime."</div></td>\n");};
									};	 
								};	 
								for ($i = 7; $i < 8; $i++) {
									if ($i == 7) {echo ("<td><div class='labelswitch'>Schaukel</div><div class='onoffswitch'>");};
									if ($summer[0] == 0 && $i == 2){
											echo ("<img id='button_".$i."' src='../img/wintermode.png'");
											echo ("</div></td>\n");
										}
									else {
										//AUS
										if ($val_array[$i][0] == 1 ) {
											echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='flipswitch_".$i."' onclick='change_pin (".$i.")'/>");
											}
										//EIN
										if ($val_array[$i][0] == 0 ) {
											echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' id='flipswitch_".$i."' onclick='change_pin (".$i.")'/>");
											}
										echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
										echo ("<span class='onoffswitch-inner'></span>");
										echo ("<span class='onoffswitch-switch'></span>");
										echo ("</label></div>");
										if ($i == 2) {echo ("<div class='minmax'>".$uwstime."</div></td>\n");};
										if ($i == 3) {echo ("<div class='minmax'>".$gartenspottime."</div></td>\n");};
										if ($i == 4) {echo ("<div class='minmax'>".$gartenlampetime."</div></td>\n");};
										if ($i == 7) {echo ("<div class='minmax'>".$schaukeltime."</div></td>\n");};
									};	 
								};	 
								?>

							<?php
							//Master AUS
							// 0 = EIN   1=AUS  wegen Relaisplatte inklusive Schalten
									echo ("<td><div class='labelswitch'>alles AUS</div><div class='onoffswitch'>");
									//AUS
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='flipswitch_99' onclick='masterOFF (0)'/>");
									//echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' id='flipswitch_99' '/>");
									echo ("<label class='onoffswitch-label' for='flipswitch_99' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									echo ("<div class='minmax'>.</div></td>\n");
								?>
					</tr>	
 				</table>
 				<table>
		        <tr>
                   	<td colspan="2"><div class="disclaimer" >CPU Temp: <?php echo $cputemp;?>°C</div></td>
		           	<td colspan="2"><div class="disclaimer" >CPU Load: <?php echo $cpuload;?>%</div></td>
	               	<td colspan="2"><div class="disclaimer" >Refresh: <?php echo $sec;?> Sekunden</div></td>
	            </tr>
	            <tr>
		           	<td colspan="2"><div class="disclaimer" >Systemstart: <?php echo $boottime;?></div></td>
		        	<td colspan="2"><div class="disclaimer" >Version: <?php echo $version;?></div></td>
                 	<td colspan="2"><div class="disclaimer" >&copy; 2016 by Thorben Knappe</div></td>
               	</tr>
			</table>
	<!-- javascript -->
	<script src="../script/scriptChangeBeregnung.js"></script>
	<script src="../script/scriptChangeBetriebsart.js"></script>
	<script src="../script/scriptGPIOFlipSwitch.js"></script>
	<script src="../script/scriptesp.js"></script>
	<script src="../script/scriptmasteroff.js"></script>
	

