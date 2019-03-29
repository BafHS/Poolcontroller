#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job prueft ob Python Scripte laufen
import os, sys, subprocess
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *
#locale version
localversion = "1.2 vom 03.10.2017"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Debug
debug=False
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOsummer,GPIO.OUT)
GPIO.setup(GPIOsummerberegnung,GPIO.OUT)


#--------------------------------------------------------------------
#Check max und min Werte ggf neu schreiben
def checkscript(scriptname):
	#Abfrage der running Scripte
	psout = subprocess.Popen(['ps', 'ax'], stdout=subprocess.PIPE).communicate()[0]
	#prüfe ob Script enthalten ist 
	if scriptname not in psout:
		#Starte Script
		subprocess.Popen([scriptname])
		#Schreibe in SQL DB
		showecho(Jobname,"Warnung",scriptname+" wurde neugestartet")
		if debug:
			print scriptname+' has not yet been started'
	else:
		if debug:
			print scriptname+' already running'
#--------------------------------------------------------------------
#Hauptroutine
if __name__ == '__main__':
	#Prüfe auf Pool-Sommer
	# GPIOsummer = 0 Winter
	# GPIOsummer = 1 Sommer
	summer = GPIO.input(GPIOsummer) 
	#Prüfe auf Beregnung-Sommer
	# GPIOsummerberegnung = 0 Winter
	# GPIOsummerberegnung = 1 Sommer
	summerberegnung = GPIO.input(GPIOsummerberegnung) 
	#prüfe Display
	checkscript('/usr/script/display.py')
	if (summer == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-0.py')
	if (summer == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-1.py')
	if (summer == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-2.py')
	#starte Kontrolle GPIO Pin x
	checkscript('/usr/script/gpioruntime-3.py')
	#starte Kontrolle GPIO Pin x
	checkscript('/usr/script/gpioruntime-4.py')
	if (summerberegnung == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-5.py')
	if (summerberegnung == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-6.py')
	if (summer == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-13.py')
	if (summer == 1):
		#starte Kontrolle GPIO Pin x
		checkscript('/usr/script/gpioruntime-14.py')
