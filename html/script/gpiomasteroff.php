<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values
//Auslesen ESP
$esp_ip = array("sonoffterrasse","SonOffschuppen","192.168.10.63");
//UWS
//set the gpio's mode to output		
system("gpio -g mode 2 out");
//set the gpio's mode to output		
system("gpio -g write 2 1"); 
//Kugellampe
//set the gpio's mode to output		
system("gpio -g mode 3 out");
//set the gpio's mode to output		
system("gpio -g write 3 1"); 
//Gartenspot
//set the gpio's mode to output		
system("gpio -g mode 4 out");
//set the gpio's mode to output		
system("gpio -g write 4 1"); 
//Schaukel
//set the gpio's mode to output		
system("gpio -g mode 7 out");
//set the gpio's mode to output		
system("gpio -g write 7 1"); 
//Test aus
//ESP 0
file_get_contents('http://'.$esp_ip[0].'/aus');
//ESP Schaukel
file_get_contents('http://'.$esp_ip[1].'/aus');


		echo($status[0]);
		


?>