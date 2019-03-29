#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job liest regelmaessig alle Sensoren nur wenn die Pumpe läuftund
#import
import os, sys, time
import RPi.GPIO as GPIO
from datetime import datetime
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import paho.mqtt.publish as publish
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#locale version
localversion = "2.0 vom 11.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Debug
debug=False
#Die GPIO Pins muessen eingerichtet werden.
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Output
GPIO.setup(GPIOpoolpumpe,GPIO.OUT)
#--------------------------------------------------------------------
#Check max und min Werte ggf neu schreiben
def minmaxsensor(sensor,typ,mqtt):
	# 1-wire Slave Datei lesen
	#if debug:
	#	file = open('/usr/script/' + sensor )
	#else:
	file = open('/sys/bus/w1/devices/' + sensor +'/w1_slave')
	filecontent = file.read()
	file.close()
	# Temperaturwerte auslesen und konvertieren
	stringvalue = filecontent.split("\n")[1].split(" ")[9]
	temperature = float(stringvalue[2:]) / 1000
	# Temperatur ausgeben
	temp=round(temperature,1)
	#Bilde Dateinanme
	filemax = '/var/www/html/'+typ+'max.txt';
	filemin = '/var/www/html/'+typ+'min.txt';
	filenow = '/var/www/html/'+typ+'now.txt';
	#Einlesen der IST Werte
	#MAX
	tempmax = readfile(filemax)
	if not (tempmax == "x"):
		tempmax = float(tempmax)
	#MIN
	tempmin = readfile(filemin)
	if tempmin != "x":
		tempmin = float(tempmin)
	if debug:
		print "-----------------------------------"
		print "Sensor: 			"+sensor
		print "Typ: 			"+typ
		#print "stringvalue: "+ stringvalue
		print "temperature:		"+ str(temperature)
		print "temp:			"+str(temp)
		print "tempmax: 		"+str(tempmax)
		print "tempmin:			"+str(tempmin)
		print "(tempmin == x) 	"+str(tempmin == "x")
		print "kleiner 			"+str(tempmin > temp)
		print "(tempmax == x) 	"+str(tempmax == "x")
		print "groesser			"+str(temp > tempmax)
	#Vergleich
	#ist MIN > NOW
	if ((tempmin > temp ) or (tempmin == "x")):
		writefile(filemin,str(temp))
	#ist NOW > MAX
	if ((temp > tempmax) or (tempmax == "x")):
		writefile(filemax,str(temp))
	#schreibe die jetzt Temp ins File
	writefile(filenow,str(temp))
	#MQTT Publish Anfang	
	MQTTTopic = MQTTtemperaturen+ "/"+mqtt
	publish.single(MQTTTopic, payload=temp, hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)
	#Rueckgabe
	return(temp)
#--------------------------------------------------------------------
#Hauptroutine
#jetzt geht es in die Endlosschleife
while True:
	tempvorlauf=minmaxsensor(w1vorlauf,'pool','Pool')
	tempruecklauf=minmaxsensor(w1ruecklauf,'ruecklauf','Ruecklauf')
	tempoutdoor=minmaxsensor(w1outdoor,'outdoor','Garten')
	tempsolar=minmaxsensor(w1solar,'solar','Solar')
	tempschuppen=minmaxsensor(w1schuppen,'schuppen','Schuppen')
	sleep(20)
	#Ist Pumpe aus 
	# GPIOpoolpumpe = 0 Ein
	# GPIOpoolpumpe = 1 Aus
	Pumpe = GPIO.input(GPIOpoolpumpe) 
	if (Pumpe == 1):
		break	
	#--------------------------------------------------------------------
