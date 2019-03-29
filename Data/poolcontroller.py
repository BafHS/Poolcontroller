#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job steuert schaltet ggf die Solaranlage zu und heizt den Pool


#import
import os, sys, time
import RPi.GPIO as GPIO
import fcntl, subprocess
from datetime import datetime
import datetime
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad umd die globalvar.py zu finden
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *
#locale version
localversion = "1.6 vom 03.10.2017"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Debug
global debug
debug = False
#im Debug Modus werden Werte geaendert
if debug:
	wait 	  = 2 * 60 #Minuten je Durchlauf in Poolcontroller
	belimo = 15

#Check auf nur eine Instance des Scriptes läuft
checkfile = open("/usr/script/poolcontroller.lock", "w+")
try:
	fcntl.flock(checkfile,fcntl.LOCK_EX | fcntl.LOCK_NB)
except IOError as e:
		data = subprocess.check_output("ps -eo pid,command | grep 'poolcontroller.py' | grep -v grep | awk '{print $1}'", shell=True)
		if debug:
			print("PID "+data)
		showecho(Jobname,"Fehler","Abbruch, Job schon gestartet mit PID " + data+" !")
		exit()

#Die GPIO Pins muessen eingerichtet werden.
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Output
GPIO.setup(GPIOreinigen,GPIO.OUT)
GPIO.setup(GPIOautomatic,GPIO.OUT)
GPIO.setup(GPIOsummer,GPIO.OUT)
GPIO.setup(GPIObypass,GPIO.OUT)
GPIO.setup(GPIOfiltern,GPIO.OUT)
GPIO.setup(GPIOpoolpumpe,GPIO.OUT)
#Finde Betriebart 
# GPIOsummer = 0 Winter
# GPIOsummer = 1 Sommer
summer = GPIO.input(GPIOsummer) 
if (summer == 0):
	#showecho(Jobname,"Fehler","Abbruch GPIO" + str(GPIOsummer) +"=0 Winterbetrieb")
	exit()
#Finde Automatic  
# GPIOautomatic = 0 manuell
# GPIOautomatic = 1 Auto
automatic = GPIO.input(GPIOautomatic) 
if (automatic == 0):
	showecho(Jobname,"Fehler","Abbruch GPIO" + str(GPIOautomatic) +"=0 manuell")
	exit()
#GPIOreinigen = 1 Filtern
#GPIOreinigen = 0 kein Filtern
reinigen = GPIO.input(GPIOreinigen) 
if (reinigen == 1):
	showecho(Jobname,"Fehler","Abbruch GPIO" + str(GPIOreinigen) +" Reinigen")
	exit()
#Funktion zum Auslesen der DS18B20
def W1read(sensor):
	# 1-wire Slave Datei lesen
	if debug:
		file = open('/usr/script/' + sensor )
	else:
		file = open('/sys/bus/w1/devices/' + sensor +'/w1_slave')
	filecontent = file.read()
	file.close()
	# Temperaturwerte auslesen und konvertieren
	stringvalue = filecontent.split("\n")[1].split(" ")[9]
	temperature = float(stringvalue[2:]) / 1000
	# Temperatur ausgeben als STRING
	# kein String zurueck temp = '%6.2f' % temperature
	temp = round(temperature,1)
	if debug:
		print (temp)
	#Rueckgabe Temperatur als Zahl
	return(temp)

#Hauptroutunie
try:
	#MAIN geht los
	showecho(Jobname,"Start","Start "+localversion+" mit Globalsettings "+versionsettings)
	#Auslesen Pool
	tempvorlauf= W1read(w1vorlauf)
	#Auslesen Pool Ruecklauf
	tempruecklauf= W1read(w1ruecklauf )
	#Auslesen Solar
	tempsolar = W1read(w1solar)
	#Differenz
	differenz = tempsolar - tempvorlauf
	differenz = round(differenz,2)
	showecho(Jobname,"Info","Vorlauf ="+str(tempvorlauf)+" Solar="+str(tempsolar)+" Differnz="+str(differenz)+" Ruecklauf="+str(tempruecklauf))
	#nur wenn Pool < LOWPool und differenz > tempdiff  dann Bypass zu warte dann Pumpe an
	if (tempvorlauf < lowpool) and (differenz >= tempdiff):
			#solarbypass zu
		GPIO.output(GPIObypass,0)
		showecho(Jobname,"Info","Solarbypass wird geschlossen")
		#warte 150 Sekunden da der Antrieb Zeit benoetigt
		time.sleep(belimo) 
		#Pumpe an
		GPIO.output(GPIOpoolpumpe,0)
		showecho(Jobname,"Info","Poolpumpe wird gestartet")
		#so jetzt in eine Schleife bis Solar <= Pool ist
		schleife = True
		durchgang = 0
		#wait = 20
		while True:
			durchgang += 1
			showecho(Jobname,"Info","Durchgang "+str(durchgang)+" Vorlauf ="+str(tempvorlauf)+" Ruecklauf="+str(tempruecklauf)+" Differnz="+str(differenz)+" Solar="+str(tempsolar))
			time.sleep(wait)
			#Abfrage der Werte
			#Auslesen Pool Vorlauf
			tempvorlauf= W1read(w1vorlauf)
			#Auslesen Pool Ruecklauf
			tempruecklauf= W1read(w1ruecklauf)
			#Auslesen Solar
			tempsolar = W1read(w1solar)
			#Differenz
			differenz = abs(tempruecklauf-tempvorlauf)
			differenz = round(differenz,2)
			#Automatic?
			automatic = GPIO.input(GPIOautomatic)
			#reinigen?
			reinigen = GPIO.input(GPIOreinigen)
			#Pumpe?
			pumpe = GPIO.input(GPIOpoolpumpe)
			#Solarbypass?
			solar = GPIO.input(GPIObypass)
			#Meldung 
			#ermittle aktuelle zeit, Job soll nur laufen in der Betriebszeit morgens und abends
			#now =  datetime.now()
			now = datetime.datetime.now().strftime("%H:%M")
			print now
			if (now > abends):
				showecho(Jobname,"Info","QUIT da Abschaltzeit erreicht ist "+abends)
				break
			#Prüfe Tempdifferenz < Deltasoll  oder Durchgänge erreicht oder automatic ist aus oder reinigen ist ein oder Maxtemp erreicht
			if ((differenz < differenzsoll) or (durchgang==durchlauf) or (automatic == 0) or (reinigen == 1) or (tempvorlauf >= maxpool) or (tempvorlauf >= tempruecklauf)):
					if (differenz <= differenzsoll):
						showecho(Jobname,"Info","QUIT, Differenz < "+str(differenzsoll)+" Vorlauf ="+str(tempvorlauf)+" Ruecklauf="+str(tempruecklauf))
					if (durchgang==durchlauf):
						showecho(Jobname,"Info","QUIT, " +str(durchgang) +" Wiederholungen")
					if (automatic == 0):
						showecho(Jobname,"Info","QUIT, Automatic = AUS!")
					if (reinigen == 1):
						showecho(Jobname,"Info","QUIT, Reinigen = EIN!")
					if (tempvorlauf >= maxpool):
						showecho(Jobname,"Info","QUIT, Max Pooltemperatur "+str(maxpool)+" !")
					if (tempvorlauf >= tempruecklauf):
						showecho(Jobname,"Info","QUIT, Vorlauf ist größer "+str(tempvorlauf)+ " als Rücklauf "+str(tempruecklauf)+" !")
					break
			if (solar == 1):
				GPIO.output(GPIObypass,0)
				showecho(Jobname,"Warnung","Solar war AUF, Wechsel -> ZU")
			if (pumpe == 1):
				GPIO.output(GPIOpoolpumpe,0)
				showecho(Jobname,"Warnung","Pumpe war AUS, Wechsel -> EIN")
		#ggf Pumpen abschalten
		#Pumpe aus, Bypass auf
		#nur filternsaugen
		reinigen = GPIO.input(GPIOreinigen)
		#nur filtern
		filtern = GPIO.input(GPIOfiltern)
		pump = "AUS"
		if ((reinigen == 0) and (filtern == 0)):
			#Pumpe aus
			GPIO.output(GPIOpoolpumpe,1)
			pump = "AUS"
		else:
			if (reinigen == 1):
				pump = "EIN da Reinigen EIN"
			if (filtern == 1):
				pump = "EIN da Filtern EIN"
		#solarbypass auf
		GPIO.output(GPIObypass,1)
		showecho(Jobname,"Normal","ENDE mit Pumpe = "+pump+", Solarbypass = AUF")
		#MAIN ende
except Exception: 
	showecho(Jobname,"Fehler","Der Job wurde mit Fehler beendet") 
	#solarbypass auf
	GPIO.output(GPIObypass,1)
	#Pumpe aus
	GPIO.output(GPIOpoolpumpe,1)
#	pass
else:
	#Freigabe Datei
	checkfile.close()
	#Status Meldung
	showecho(Jobname,"Ende","Script fehlerfrei beendet")
