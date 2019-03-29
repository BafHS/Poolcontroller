#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird von Startupcontroller gestartet 
# Es werden Werte an den MQTT Server geliefert
#import
import os, sys, time
import RPi.GPIO as GPIO
from datetime import datetime, date
from time import sleep  # sleep importieren
import paho.mqtt.client as mqtt
import paho.mqtt.publish as publish
import psutil
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#debug
debug = True
#locale version
localversion = "1.0 vom 10.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Setup Pin
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
#Setze port auf Input
GPIO.setup(GPIOsummer,GPIO.OUT)
GPIO.setup(GPIOsummerberegnung,GPIO.OUT)
#MQTT
MQTTTopic = MQTTtemperaturen
MQTTTopicLWT = MQTTpoolcontroller 
#MQTT Definitionen
def on_connect(client, userdata, flags, rc):
	
	if rc == 0:
		print("Verbunden")
	else:
		print("keine Verbindung Fehler "+str(rc))
		showecho(Jobname,"MQTT","Verbindungsfehler "+str(rc))
#MQTT sende Nachricht
def on_publish(mosq, obj, mid):
    print("mid: " + str(mid))
#MQTT Client
client = mqtt.Client()
# Register connect callback
client.on_connect = on_connect
#MQTT LWT
client.will_set(MQTTTopicLWT, payload="Offline", qos=0, retain=True)
# Connect to Server MQTT port and 60 seconds keepalive interval
try:
	client.connect(MQTTServer, 1883, 60)
except:
	print("connection failed")
	showecho(Jobname,"Fehler","MQTT Server " + MQTTServer + " Connection refused")
#MQTT Client setzen
client.loop_start()
#setzte Status
client.publish(MQTTTopic+"/Status", "Online",qos=0,retain=False)
#Auslesen Boot Zeit Controller
boottime=readfile('/var/www/html/boottime.txt');
client.publish(MQTTTopic+"/Controller/boottime", boottime,qos=0,retain=False)

#jetzt geht es in die Endlosschleife
while True:
	# Auslesen CPU Temp
	cputemp=int(readfile("/sys/class/thermal/thermal_zone0/temp"));
	cputemp=str(cputemp / 1000)
	client.publish(MQTTTopic+"/Controller/cputemp", cputemp,qos=0,retain=False)
	#Auslesen CPU LOad
	cpuload=str(psutil.cpu_percent())
	client.publish(MQTTTopic+"/Controller/cpuload", cpuload,qos=0,retain=False)
	#Sommermodus Pool
	Pin = GPIO.input(GPIOsummer)
	if (Pin == 0):
		temp = "OFF"
	if (Pin == 1):
		temp = "ON"
	client.publish(MQTTTopic+"/Pool/Sommer", temp,qos=0,retain=False)
		
	#Sommermodus Beregnung
	Pin = GPIO.input(GPIOsummerberegnung)
	if (Pin == 0):
		temp = "OFF"
	if (Pin == 1):
		temp = "ON"
	client.publish(MQTTTopic+"/Beregnung/Sommer", temp,qos=0,retain=False)
	#Sammlen der Druck Werte
	ReadAnalogKanal(0)
	ReadAnalogKanal(1)
	ReadAnalogKanal(2)
	ReadAnalogKanal(3)
	ReadAnalogKanal(4)
	ReadAnalogKanal(5)
	ReadAnalogKanal(6)
	ReadAnalogKanal(7)

	

	if debug:
		print("CPU Temp "+cputemp)
		print("CPU Load" +cpuload)
	#warte Zeit in Sekunden
	time.sleep(triggerlong)

	