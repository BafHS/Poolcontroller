#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Diese Job startet jeden Mittag die Pumpe zum filtern, abhängig von der täglichen zeit zur IST Zeit
import os, sys, time
import RPi.GPIO as GPIO
from datetime import datetime, date
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#debug
debug = False
#locale version
localversion = "1.3 vom 25.07.2017"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOpoolpumpe,GPIO.OUT)
GPIO.setup(GPIOfiltern,GPIO.OUT)
GPIO.setup(GPIOsummer,GPIO.OUT)
GPIO.setup(GPIOautomatic,GPIO.OUT)
#Finde Betriebart 
# GPIOsummer = 0 Winter
# GPIOsummer = 1 Sommer
summer = GPIO.input(GPIOsummer) 
if (summer == 0):
	showecho(Jobname,"Warnung","Abbruch GPIO" + str(GPIOsummer) +"=0 Winterbetrieb")
	exit()
#Finde Automatic  
# GPIOautomatic = 0 manuell
# GPIOautomatic = 1 Auto
automatic = GPIO.input(GPIOautomatic) 
if (automatic == 0):
	showecho(Jobname,"Warnung","Abbruch GPIO" + str(GPIOautomatic) +"=0 manuell")
	exit()
#Auslesen Laufzeit Pumpe in Sekunden/tag
pumptime=int(readfile('/var/www/html/GPIO0.txt'))
#Durchlauf in Minuten
dauersoll = int(dauermittag) * 3600 # Minuten -> Sekunden
#Differenz aus SOLL und IST
dauer = dauersoll - pumptime
dauertemp = dauer
pumpenstunde=dauertemp // 3600
dauertemp %= 3600
pumpenminute=dauertemp // 60
pumpentime=str(pumpenstunde)+"h:"+str(pumpenminute)+"m"
dauertemp = dauersoll
pumpenstunde=dauertemp // 3600
dauertemp %= 3600
pumpenminute=dauertemp // 60
pumpentimesoll=str(pumpenstunde)+"h:"+str(pumpenminute)+"m"
if debug:
	print "pumpentime "+pumpentime
	print "pumptime "+str(pumptime)
# Pumpenlaufzeit erreicht QUIT
if (dauer <= 0):
	showecho(Jobname,"Info","EXIT, Pumpenlaufzeit Soll "+pumpentimesoll+" erreicht.")
	exit()
# MAIN geht los
showecho(Jobname,"Normal","Start "+localversion+" Globalsettings "+globalversion);
#setze GPIO14 auf 1 = Filter
GPIO.output(GPIOfiltern,1)
#Pumpe ein
#GPIO.output(GPIOpoolpumpe,0)
showecho(Jobname,"Normal","Pumpe startet fuer "+pumpentime);
#warte die zeit ab
sleep(dauer);
#Pumpe aus
#GPIO.output(GPIOpoolpumpe,1)
#setze GPIO14 auf 0 = Filter
GPIO.output(GPIOfiltern,0)
# Ende
showecho(Jobname,"Normal","Ende "+localversion);
