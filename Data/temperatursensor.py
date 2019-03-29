#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job liest regelmaessig alle Sensoren und Druckwerte und schreibt alles in die SQL DB


#import
import os, sys, time
import RPi.GPIO as GPIO
from datetime import datetime
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import paho.mqtt.client as mqtt
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#locale version
localversion = "1.5 vom 11.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Debug
debug=False
#Setzen GPIO	# Main program block
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM) # Use BCM GPIO numbers
GPIO.setup(GPIOpoolpumpe, GPIO.OUT) # E
GPIO.setup(GPIObypass, GPIO.OUT) # E
GPIO.setup(GPIOautomatic, GPIO.OUT) # E
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
	#Schreibe in SQL DB
	mysql_procedure('checktemp',typ,temp)
	#MQTT Publish Anfang	
	MQTTTopic = MQTTtemperaturen+ "/"+mqtt
	client.publish(MQTTTopic, temp ,qos=0,retain=True)	
	#Rueckgabe
	return(temp)
#--------------------------------------------------------------------
#MQTT Definitionen
def on_connect(client, userdata, flags, rc):
	if rc == 0:
		print("Verbunden")
	else:
		print("keine Verbindung Fehler "+str(rc))
	client.subscribe(MQTTTopic)
#MQTT empfangene Nachricht
def on_message(client, userdata, msg):
	message = str(msg.payload)
	print(msg.topic+" "+message)
	if message == 'Ein':
		#Schalte GPIO ein
		GPIO.output(GPIOPin,0)
		Pinstate = 0
	if message == 'Aus':
		#Schalte GPIO aus
		GPIO.output(GPIOPin,1)
		Pinstate = 1
#MQTT sende Nachricht
def on_publish(mosq, obj, mid):
    print("mid: " + str(mid))
#MQTT Client
client = mqtt.Client()
# Register connect callback
client.on_connect = on_connect
# Registed publish message callback
client.on_message = on_message
# Connect to Server MQTT port and 60 seconds keepalive interval
try:
	client.connect(MQTTServer, 1883, 60)
except:
	showecho(Jobname,"Fehler","MQTT Server " + MQTTServer + " Connection refused")
	print("connection failed")
client.loop_start()
#--------------------------------------------------------------------
#Hauptroutine
if __name__ == '__main__':
	tempvorlauf=minmaxsensor(w1vorlauf,'pool','Pool')
	tempruecklauf=minmaxsensor(w1ruecklauf,'ruecklauf','Ruecklauf')
	tempoutdoor=minmaxsensor(w1outdoor,'outdoor','Garten')
	tempsolar=minmaxsensor(w1solar,'solar','Solar')
	tempschuppen=minmaxsensor(w1schuppen,'schuppen','Schuppen')
	pumpe=GPIO.input(GPIOpoolpumpe)
	bypass=GPIO.input(GPIObypass)
	automatic=GPIO.input(GPIOautomatic)
	
	#Schreibe in SQL DB
	sql_query = "INSERT INTO pooltemp VALUES (now(), "+str(tempvorlauf)+","+str(tempruecklauf)+","+str(tempoutdoor)+","+str(tempsolar)+","+str(tempschuppen)+","+str(automatic)+","+str(pumpe)+","+str(bypass)+");"
	if debug:
		print sql_query
	mysql_query(sql_query)
	druckwasser0=ReadAnalogKanal(0)
	mysql_procedure('checkanalog','druckwasser0',druckwasser0)

#--------------------------------------------------------------------
