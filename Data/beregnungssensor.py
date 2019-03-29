#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird von gpioruntime-5 (Pumpe) oder gpioruntime-6 (Magnetventil) gestartet 
#import
import os, sys, time
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *
from datetime import datetime, date
import fcntl, subprocess
import RPi.GPIO as GPIO # GPIO-Library
import spidev           # SPI-Dev Library
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import paho.mqtt.publish as publish
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#debug
debug = False
#locale version
localversion = "1.4 vom 21.02.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Check auf nur eine Instance des Scriptes läuft
checkfile = open("/usr/script/beregnungssensor.lock", "w+")
try:
	fcntl.flock(checkfile,fcntl.LOCK_EX | fcntl.LOCK_NB)
except IOError as e:
		data = subprocess.check_output("ps -eo pid,command | grep 'beregnungssensor.py' | grep -v grep | awk '{print $1}'", shell=True)
		if debug:
			print("PID "+data)
		showecho(Jobname,"Fehler","Abbruch, Job schon gestartet mit PID " + data+" !")
		exit()


#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOgartenpumpe,GPIO.OUT)
GPIO.setup(GPIOmagnetventil,GPIO.OUT)
GPIO.setup(GPIOsummerberegnung,GPIO.OUT)
#Anfangswert
PinPumpeNow = GPIO.input(GPIOgartenpumpe)
PinVentilNow = GPIO.input(GPIOmagnetventil)

#debug
debug = True

#Funktion auslesen MCP3208
def ReadAnalogSQL():
	#Dauerschleife
	#while True:
	#Sammlen der Analog Werte
	druckwasser0=ReadAnalogKanal(0)
	mysql_procedure('checkanalog','druckwasser0',druckwasser0)
	druckwasser1=ReadAnalogKanal(1)
	mysql_procedure('checkanalog','druckwasser1',druckwasser1)
	druckwasser2=ReadAnalogKanal(2)
	mysql_procedure('checkanalog','druckwasser2',druckwasser2)
	druckwasser3=ReadAnalogKanal(3)
	mysql_procedure('checkanalog','druckwasser3',druckwasser3)
	druckwasser4=ReadAnalogKanal(4)
	mysql_procedure('checkanalog','druckwasser4',druckwasser4)
	if debug:
		print ("Druckwasser0  " + str(druckwasser0)+" Druckwasser1  " + str(druckwasser1)+" Druckwasser2  " + str(druckwasser2)+" Druckwasser3  " + str(druckwasser3)+" Druckwasser4  " + str(druckwasser4))

		
#open Spidev
#global spi
#OpenSpiDev()
#spi = spidev.SpiDev()
#spi.open(0,0)
#jetzt geht es in die Endlosschleife
#ReadAnalogSQL()
while True:
	#Winterbetrieb QUIT
	summer = GPIO.input(GPIOsummerberegnung)
	if (summer == 0):
		exit()
	#Abfrage der Druckwerte
	ReadAnalogSQL()
	#warte Zeit in Sekunden
	time.sleep(trigger)
	#Finde aktiven Kreislauf
	kreislauf = findKreislauf()
	#Frage Pin ab
	PinPumpeNow = GPIO.input(GPIOgartenpumpe)
	PinVentilNow = GPIO.input(GPIOmagnetventil)
	if (PinPumpeNow == 0) or (PinVentilNow == 0):
		a=0
		#Beregnung läuft
	else:
		#Beregnung aus Abbruch
		if (NachAusAbfrage > 0):
			NachAusAbfrage = NachAusAbfrage - 1
			if debug:
				print("NachAusAbfrage "+str(NachAusAbfrage))
		else:
			#verlasse die schleife
			break
