#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird von Startupcontroller gestartet 
# es wird die Einschaltzeit des Pins 7 gemessen.
# Pin 7 = Lampe Schaukel
#import
import os, sys, time
import RPi.GPIO as GPIO
from datetime import datetime, date
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

#debug
debug = False
#locale version
localversion = "1.6 vom 11.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Welcher Pin
GPIOPin = 7
PinLog = "GPIO 7"
PinName = "Schaukel"
PinFile = "/var/www/html/GPIO7.txt"
MQTTTopic = MQTTschaukel 
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOPin,GPIO.OUT)
GPIO.setup(GPIOsummer,GPIO.OUT)
#Anfangswert
Pinstate = GPIO.input(GPIOPin)
# Start Datum
from_script = datetime.today()
#Reset Datum auf Tag 00:00:00
from_script=from_script.replace(hour=0,minute=0,second=0,microsecond=0)
#start Zeit
to_time = datetime.now()
#definition Laufzeit
laufzeit = 0
time_diff = 0
#schreibe Datei
writefile(PinFile,str(laufzeit))
# Wegen der Relaisplatte
# 0 = EIN
# 1 = AUS
if (Pinstate == 0):
	from_time=datetime.now()
	state = True
	mqttstate = "Ein"
else:
	state = False
	mqttstate = "Aus"
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
#Publish Anfang
client.publish(MQTTTopic, mqttstate,qos=0,retain=True)

#jetzt geht es in die Endlosschleife
while True:
	#warte Zeit in Sekunden
	time.sleep(trigger)
	#Frage Pin ab
	Pin = GPIO.input(GPIOPin)
	if debug:
		print("Pinstate "+str(Pinstate)+" Pin "+str(Pin))
		print(state)
	if (Pinstate != Pin):
		if (Pin == 1):
			to_time = datetime.now()
			time_diff = (to_time - from_time).seconds
			laufzeit = laufzeit + time_diff
			state = False;
			showecho(Jobname,"GPIO",PinLog+" "+PinName+" Wechsel 0(EIN) -> 1(AUS)")
			writefile(PinFile,str(laufzeit))
			client.publish(MQTTTopic, "Aus",qos=0,retain=True)
			if debug:
				print("laufzeit "+str(laufzeit)+" Differenz "+str(time_diff))
				print(from_time)
				print(to_time)
		if (Pin == 0):
			showecho(Jobname,"GPIO",PinLog+" "+PinName+" Wechsel 1(AUS) -> 0 (EIN)")
			client.publish(MQTTTopic, "Ein",qos=0,retain=True)
			from_time = datetime.now()
			state = True
		Pinstate = Pin
	else:
		if (state):
			to_time = datetime.now()
			time_diff = (to_time - from_time).seconds
			dauer = laufzeit + time_diff
			writefile(PinFile,str(dauer))
			if debug:
				print("laufzeit "+str(laufzeit)+" Differenz "+str(time_diff))
				print(from_time)
				print(to_time)
	#finde Tageswechsel
	to_script = datetime.today()
	scriptdiff = (to_script - from_script)
	if (scriptdiff.days >= 1) and (scriptdiff.seconds >= 120):
		#Neuer Tag
		from_script = datetime.today()
		from_script = from_script.replace(hour=0,minute=0,second=0,microsecond=0)
		laufzeit = 0
		writefile(PinFile,str(laufzeit))
		showecho(Jobname,"Info","Neuer Tag");
