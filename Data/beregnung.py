#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Diese Job startet die Beregnung
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
debug = True
debugTimer = False
debugGPIO = False
#locale version
localversion = "2.9 vom 15.08.2018"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Output
GPIO.setup(GPIOgartenpumpe,GPIO.OUT)
GPIO.setup(GPIOmagnetventil,GPIO.OUT)
GPIO.setup(GPIOautomaticberegnung,GPIO.OUT)
GPIO.setup(GPIOsummerberegnung,GPIO.OUT)
#Melde Beginn
showecho(Jobname,"Start","Start "+localversion+" Globalsettings "+globalversion);
#Finde Betriebart 
# GPIOsummer = 0 Winter
# GPIOsummer = 1 Sommer
summer = GPIO.input(GPIOsummerberegnung) 
if (summer == 0):
	showecho(Jobname,"Ende","Abbruch GPIO" + str(GPIOsummerberegnung) +"=0 Winterbetrieb")
	exit()
#Finde Automatic  
# GPIOautomatic = 0 manuell
# GPIOautomatic = 1 Auto
automatic = GPIO.input(GPIOautomaticberegnung) 
if (automatic == 0):
	showecho(Jobname,"Ende","Abbruch GPIO" + str(GPIOautomaticberegnung) +"=0 manuell")
	exit()
#Auslesen Beregnung Morgens aktiv
beregnungmorgens=readfile('/var/www/html/beregnungmorgens.txt')
beregnungmittags=readfile('/var/www/html/beregnungmittags.txt')
beregnungabends=readfile('/var/www/html/beregnungabends.txt')
#Auslesen der aktuellen Bodenfeuchte
bodendatum, bodenwert = read_bodenwerte()
#In Abhängigkeit der Bodenfeuchtigkeit
if (bodenwert >= bodenfeuchtigkeitsoll):
	showecho(Jobname,"Ende","Feuchtigkeit IST " + str(bodenwert) +"% => SOLL "+str(bodenfeuchtigkeitsoll)+"% gemessen am " + str(bodendatum))
	exit()
#Auslesen Laufzeit Zuleitung/tag
#DauerIst0=int(readfile('/var/www/html/GPIO6.txt'))
DauerIst0=0
#Auslesen Laufzeit Kreislauf1/tag
#DauerIst1=int(readfile('/var/www/html/kreislauf1.txt'))
DauerIst1=0
#Auslesen Laufzeit Kreislauf2/tag
#DauerIst2=int(readfile('/var/www/html/kreislauf2.txt'))
DauerIst2=0
#Auslesen Laufzeit Kreislauf3/tag
#DauerIst3=int(readfile('/var/www/html/kreislauf3.txt'))
DauerIst3=0
DauerIst4=0
now = datetime.now().strftime("%H:%M")
print now
if (now <  "11:00"):
	if (beregnungmorgens == "off"):
		showecho(Jobname,"Ende","Beregnung Morgens deaktiviert, ABBRUCH!")
		exit()
	kreislauf1 =kreislaufmorgens1 
	kreislauf2 =kreislaufmorgens2 
	kreislauf3 =kreislaufmorgens3 
	kreislauf4 =kreislaufmorgens4 
	kreislauf5 =kreislaufmorgens5 
elif (now <  "13:00"):
	if (beregnungmittags == "off"):
		showecho(Jobname,"Ende","Beregnung Mittags deaktiviert, ABBRUCH!")
		exit()
	kreislauf1 =kreislaufmittags1 
	kreislauf2 =kreislaufmittags2 
	kreislauf3 =kreislaufmittags3 
	kreislauf4 =kreislaufmittags4 
	kreislauf5 =kreislaufmittags5 
else:
	# Abends deaktiviert
	if (beregnungabends == "off"):
		showecho(Jobname,"Ende","Beregnung Abends deaktiviert, ABBRUCH!")
		exit()
#Debug Werte
if debugTimer:
	kreislauf1 = 1
	kreislauf2 = 1
	kreislauf3 = 1
	kreislauf4 = 1
#Durchlauf in Minuten
DauerSoll1 = int(kreislauf1) * 60 # Minuten -> Sekunden
DauerSoll2 = int(kreislauf2) * 60 # Minuten -> Sekunden
DauerSoll3 = int(kreislauf3) * 60 # Minuten -> Sekunden
DauerSoll4 = int(kreislauf4) * 60 # Minuten -> Sekunden
DauerSoll0 = DauerSoll1 + DauerSoll2 + DauerSoll3 + DauerSoll4
DauerSollMinuten = kreislauf1 + kreislauf2 + kreislauf3 + kreislauf4
if debug:
	print "Dauer0 "+str(DauerSoll0)+" Dauer1 "+str(DauerSoll1)	+" Dauer2 "+str(DauerSoll2)+" Dauer3 "+str(DauerSoll3)+" Dauer4 "+str(DauerSoll4)
#Differenz aus SOLL und IST
#ermittle Gesamtzeit
DauerRun0 = DauerSoll0 - DauerIst0
temp = DauerRun0
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerRunStr0=str(tempstunde)+"h:"+str(tempminute)+"m"
#Soll Zeit als String
temp = DauerSoll0
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerSollStr0=str(tempstunde)+"h:"+str(tempminute)+"m"

#ermittle Kreislauf 1
DauerRun1 = DauerSoll1 - DauerIst1
temp = DauerRun1
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerRunStr1=str(tempstunde)+"h:"+str(tempminute)+"m"
#Soll Zeit als String
temp = DauerSoll1
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerSollStr1=str(tempstunde)+"h:"+str(tempminute)+"m"

#ermittle Kreislauf 2
DauerRun2 = DauerSoll2 - DauerIst2
temp = DauerRun2
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerRunStr2=str(tempstunde)+"h:"+str(tempminute)+"m"
#Soll Zeit als String
temp = DauerSoll2
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerSollStr2=str(tempstunde)+"h:"+str(tempminute)+"m"

#ermittle Kreislauf 3
DauerRun3 = DauerSoll3 - DauerIst3
temp = DauerRun3
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerRunStr3=str(tempstunde)+"h:"+str(tempminute)+"m"
#Soll Zeit als String
temp = DauerSoll3
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerSollStr3=str(tempstunde)+"h:"+str(tempminute)+"m"

#ermittle Kreislauf 4
DauerRun4 = DauerSoll4 - DauerIst4
temp = DauerRun4
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerRunStr4=str(tempstunde)+"h:"+str(tempminute)+"m"
#Soll Zeit als String
temp = DauerSoll4
tempstunde=temp // 3600
temp %= 3600
tempminute=temp // 60
DauerSollStr4=str(tempstunde)+"h:"+str(tempminute)+"m"
if (now <  "11:00"):
	showecho(Jobname,"Info","Morgens Dauer " +DauerRunStr0+", Feuchtigkeit IST " + str(bodenwert) +"%")
elif (now <  "13:00"):
	showecho(Jobname,"Info","Mittags Dauer " +DauerRunStr0+", Feuchtigkeit IST " + str(bodenwert) +"%")
else:
	showecho(Jobname,"Info","Abends Dauer " +DauerRunStr0+", Feuchtigkeit IST " + str(bodenwert) +"%")
if debug:
	print "DauerRun0 "+str(DauerRun0)+" DauerSoll0 "+str(DauerSoll0)+" DauerIst0 "+str(DauerIst0)+" DauerRunStr0 "+DauerRunStr0+" DauerSollStr0 "+DauerSollStr0
	print "DauerRun1 "+str(DauerRun1)+" DauerSoll1 "+str(DauerSoll1)+" DauerIst1 "+str(DauerIst1)+" DauerRunStr1 "+DauerRunStr1+" DauerSollStr1 "+DauerSollStr1
	print "DauerRun2 "+str(DauerRun2)+" DauerSoll2 "+str(DauerSoll2)+" DauerIst2 "+str(DauerIst2)+" DauerRunStr2 "+DauerRunStr2+" DauerSollStr2 "+DauerSollStr2	
	print "DauerRun3 "+str(DauerRun3)+" DauerSoll3 "+str(DauerSoll3)+" DauerIst3 "+str(DauerIst3)+" DauerRunStr3 "+DauerRunStr3+" DauerSollStr3 "+DauerSollStr3	
	print "DauerRun4 "+str(DauerRun4)+" DauerSoll4 "+str(DauerSoll4)+" DauerIst4 "+str(DauerIst4)+" DauerRunStr4 "+DauerRunStr4+" DauerSollStr4 "+DauerSollStr4	
# Pumpenlaufzeit erreicht QUIT
if (DauerRun0 <= 0):
	showecho(Jobname,"Info","EXIT, Pumpenlaufzeit Soll "+DauerRunStr0+" erreicht.")
	exit()
# MAIN geht los
#Lese Druckwerte vor dem Start
#Auslesen Druck Kanal 0
druckwasser0=readfile('/var/www/html/Kanal0.txt')
#Auslesen Druck Kanal 1
druckwasser1=readfile('/var/www/html/Kanal1.txt')
#Auslesen Druck Kanal 2
druckwasser2=readfile('/var/www/html/Kanal2.txt')
#Auslesen Druck Kanal 3
druckwasser3=readfile('/var/www/html/Kanal3.txt')
#Auslesen Druck Kanal 4
druckwasser4=readfile('/var/www/html/Kanal4.txt')
try:
	if not debugGPIO:
		#schalte Magnetventil ein
		GPIO.output(GPIOmagnetventil,0)
		#schalte Pumpe ein
		#GPIO.output(GPIOgartenpumpe,0)
	#showecho(Jobname,"Normal","Beregnung startet fuer "+DauerRunStr0);
	#Finde aktiven Kreislauf
	kreislauf = findKreislauf()
	showecho(Jobname,"Info","Beregnung fuer Kreislauf "+str(kreislauf));
	#Ermittle die Startzeit fuer die Gesamtberegnung
	from_timeAll=datetime.now()
	#Ermittle Startzeit fuer den Kreislauf
	from_timeChannel=datetime.now()
	#jetzt geht es in die Endlosschleife
	while True:
		#warte Zeit in Sekunden
		time.sleep(triggerberegnung)
		#Finde Gesamtzeit fuer den Kreislauf
		to_time = datetime.now()
		time_diff = (to_time - from_timeAll).seconds
		DauerNow0 = DauerIst0 + time_diff
		if DauerNow0 > DauerSoll0:
			showecho(Jobname,"Info","Beregnung Dauer "+DauerSollStr0+" erreicht, Programmende")
			break
		#Finde Automatic  
		# GPIOautomatic = 0 manuell
		# GPIOautomatic = 1 Auto
		automatic = GPIO.input(GPIOautomaticberegnung) 
		if (automatic == 0):
			showecho(Jobname,"Ende","Automatik für Beregnung ist aus")
			break
		#Behandlung Kreislauf1
		if (kreislauf == 1):
			to_time = datetime.now()
			time_diff = (to_time - from_timeChannel).seconds
			DauerNow1 = DauerIst1 + time_diff
			writefile('/var/www/html/kreislauf1.txt',str(DauerNow1))
			if debug:
				print "--->DauerNow1 "+str(DauerNow1)
			if DauerNow1 >= DauerSoll1:
				#wechsel auf neuen Kreislauf
				showecho(Jobname,"Info","Kreislauf 1 Dauer "+DauerSollStr1+" erreicht.")
				#Pumpe & Magnetventil aus
				#GPIO.output(GPIOgartenpumpe,1)
				GPIO.output(GPIOmagnetventil,1)
				sleep(8)
				#schalte Pumpe & Magnetventil ein
				if not debugGPIO:
					GPIO.output(GPIOmagnetventil,0)
					#GPIO.output(GPIOgartenpumpe,0)
				sleep(8)
				#Finde aktiven Kreislauf
				kreislauf = findKreislauf()
				showecho(Jobname,"Info","Beregnung fuer Kreislauf "+str(kreislauf));
				#Ermittle neue Startzeit fuer den kreislauf
				from_timeChannel=datetime.now()
				if debug:
					print "++> Wechsel von 1 -> "+str(kreislauf)
		#Behandlung Kreislauf2
		if (kreislauf == 2):
			to_time = datetime.now()
			time_diff = (to_time - from_timeChannel).seconds
			DauerNow2 = DauerIst2 + time_diff
			writefile('/var/www/html/kreislauf2.txt',str(DauerNow2))
			if debug:
				print "--->DauerNow2 "+str(DauerNow2)
			if DauerNow2 >= DauerSoll2:
				#wechsel auf neuen Kreislauf
				showecho(Jobname,"Info","Kreislauf 2 Dauer "+DauerSollStr2+" erreicht.")
				#Pumpe & Magnetventil aus
				#GPIO.output(GPIOgartenpumpe,1)
				GPIO.output(GPIOmagnetventil,1)
				sleep(8)
				#schalte Pumpe ein
				if not debugGPIO:
					GPIO.output(GPIOmagnetventil,0)
					#GPIO.output(GPIOgartenpumpe,0)
				sleep(8)
				#Finde aktiven Kreislauf
				kreislauf = findKreislauf()
				showecho(Jobname,"Info","Beregnung fuer Kreislauf "+str(kreislauf));
				#Ermittle neue Startzeit fuer den kreislauf
				from_timeChannel=datetime.now()
				if debug:
					print "++> Wechsel von 2 -> "+str(kreislauf)
		#Behandlung Kreislauf3
		if (kreislauf == 3):
			to_time = datetime.now()
			time_diff = (to_time - from_timeChannel).seconds
			DauerNow3 = DauerIst3 + time_diff
			writefile('/var/www/html/kreislauf3.txt',str(DauerNow3))
			if debug:
				print "--->DauerNow3 "+str(DauerNow3)
			if DauerNow3 >= DauerSoll3:
				#wechsel auf neuen Kreislauf
				showecho(Jobname,"Info","Kreislauf 3 Dauer "+DauerSollStr3+" erreicht.")
				#Pumpe & Magnetventil aus
				#GPIO.output(GPIOgartenpumpe,1)
				GPIO.output(GPIOmagnetventil,1)
				sleep(8)
				#schalte Pumpe ein
				if not debugGPIO:
					GPIO.output(GPIOmagnetventil,0)
					#GPIO.output(GPIOgartenpumpe,0)
				sleep(8)
				#Finde aktiven Kreislauf
				kreislauf = findKreislauf()
				showecho(Jobname,"Info","Beregnung fuer Kreislauf "+str(kreislauf));
				#Ermittle neue Startzeit fuer den kreislauf
				from_timeChannel=datetime.now()
				if debug:
					print "++> Wechsel von 3 -> "+str(kreislauf)
		#Behandlung Kreislauf4
		if (kreislauf == 4):
			to_time = datetime.now()
			time_diff = (to_time - from_timeChannel).seconds
			DauerNow4 = DauerIst4 + time_diff
			writefile('/var/www/html/kreislauf4.txt',str(DauerNow4))
			if debug:
				print "--->DauerNow4 "+str(DauerNow4)
			if DauerNow4 >= DauerSoll4:
				#wechsel auf neuen Kreislauf
				showecho(Jobname,"Info","Kreislauf 4 Dauer "+DauerSollStr4+" erreicht.")
				#Pumpe & Magnetventil aus
				#GPIO.output(GPIOgartenpumpe,1)
				GPIO.output(GPIOmagnetventil,1)
				sleep(8)
				#schalte Pumpe ein
				if not debugGPIO:
					GPIO.output(GPIOmagnetventil,0)
					#GPIO.output(GPIOgartenpumpe,0)
				sleep(8)
				#Finde aktiven Kreislauf
				kreislauf = findKreislauf()
				showecho(Jobname,"Info","Beregnung fuer Kreislauf "+str(kreislauf));
				#Ermittle neue Startzeit fuer den kreislauf
				from_timeChannel=datetime.now()
				if debug:
					print "++> Wechsel von 4 -> "+str(kreislauf)
		#Finde Automatic  
		# GPIOautomatic = 0 manuell
		# GPIOautomatic = 1 Auto
		automatic = GPIO.input(GPIOautomaticberegnung) 
		if (automatic == 0):
			showecho(Jobname,"Warnung","Abbruch Automatik AUS GPIO" + str(GPIOautomaticberegnung) +"=0 manuell")
			break
		if debug:
			print "DauerNow0 "+str(DauerNow0)+" Kreislauf "+str(kreislauf)
		
	#Ende Schleife
	# Ende
#except Exception as e: print(e)
except Exception: 
	showecho(Jobname,"Fehler","Der Job wurde mit Fehler beendet") 
	#Magnetventil aus
	GPIO.output(GPIOmagnetventil,1)
#	pass
else:
	#Pumpe aus
	#GPIO.output(GPIOgartenpumpe,1)
	#sleep(5)
	#Magnetventil aus
	GPIO.output(GPIOmagnetventil,1)
	#Freigabe Datei
	#checkfile.close()
	#Status Meldung
	showecho(Jobname,"Ende","Script fehlerfrei beendet")
