#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird von gpioruntime-0 (PoolPumpe) gestartet 
#import
import os, sys, time
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *
from datetime import datetime, date
import RPi.GPIO as GPIO # GPIO-Library
import spidev           # SPI-Dev Library
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren

#debug
debug = False
#locale version
localversion = "1.3 vom 21.02.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOpoolpumpe,GPIO.OUT)
GPIO.setup(GPIOsummer,GPIO.OUT)
#Anfangswert
PinPumpeNow = GPIO.input(GPIOpoolpumpe)
#
global sandfilterokay
sandfilterokay = True
	
#Funktion auslesen MCP3208
def ReadAnalogSQL():
	global sandfilterokay
	#Sammlen der Analog Werte
	druckwasser6=ReadAnalogKanal(6)
	mysql_procedure('checkanalog','druckwasser6',druckwasser6)
	if debug:
		print ("Druckwasser6  " + str(druckwasser6))
	if (druckwasser6 >= sandfilterdruckwarnung) and sandfilterokay:
		#log in SQL DB
		showecho(Jobname,"Warnung","Der Druck im Sandfilter ist "+str(druckwasser6)+" Bar und größer als "+str(sandfilterdruckwarnung)+" Bar. Bitte Rückspülen.")
		# call sendmail() and generate a new mail with specified subject and content
		sendmail('tk@bvg.de','Der Druck im Sandfilter ist '+str(druckwasser6)+' Bar und größer als '+str(sandfilterdruckwarnung)+' Bar. Bitte Rückspülen.')
		#keine Neue Warnung
		sandfilterokay = False
#jetzt geht es in die Endlosschleife
while True:
	#Winterbetrieb QUIT
	summer = GPIO.input(GPIOsummer)
	if (summer == 0):
		exit()
	#Abfrage der Druckwerte
	ReadAnalogSQL()
	#warte Zeit in Sekunden
	time.sleep(trigger)
	#Frage Pin ab
	PinPoolPumpe = GPIO.input(GPIOpoolpumpe)
	if (PinPoolPumpe == 0):
		a=0
		#Poolpumpe läuft
	else:
		#Beregnung aus Abbruch
		if (NachAusAbfrage > 0):
			NachAusAbfrage = NachAusAbfrage - 1
			if debug:
				print("NachAusAbfrage "+str(NachAusAbfrage))
		else:
			#verlasse die schleife
			break