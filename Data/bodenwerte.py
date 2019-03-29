#!/usr/bin/python
# -*- mode: python; coding: utf-8 -*-

# Scans for and reads data from Xiaomi flower monitor and publish via MQTT
# Tested on firmware version 2.6.2 &  2.6.6 & 2.9.4
# Xiaomi flower protocol & code from https://wiki.hackerspace.pl/projects:xiaomi-flora by emeryth (emeryth at hackerspace.pl)
# NB, change in the last line your mqtt server & authentication details if needed
# Author Marcel Verpaalen

import sys, os, time
from struct import unpack
import paho.mqtt.publish as publish
from gattlib import DiscoveryService, GATTRequester, GATTResponse
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#locale version
localversion = "1.6 vom 15.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#Debug
debug=True

#Auslesen Fehleranzahl Bodensensor
bodensensorfehlerdatei='/var/www/html/bodensensorfehler.txt'
bodensensorfehler = int(readfile(bodensensorfehlerdatei))


verbose = True

service = DiscoveryService("hci0")
devices = service.discover(15)

baseTopic = MQTTbodenwerte
msgs=[]

for address, name in list(devices.items()):
    try:	
	if (debug):
		print("name: {}, address: {}".format(name, address))
	if (name == "Flower mate" or name == "Flower care"):
		topic= baseTopic + '/'
		requester = GATTRequester(address, True)
		#Read battery and firmware version attribute
		data=requester.read_by_handle(0x0038)[0]
		battery, firmware = unpack('<xB5s',data)
		msgs.append({'topic': topic + 'Device', 'payload':address.replace(':', '')})
		msgs.append({'topic': topic + 'Batterie', 'payload':battery})
		msgs.append({'topic': topic + 'Firmware', 'payload':firmware})
		#Enable real-time data reading
		requester.write_by_handle(0x0033, str(bytearray([0xa0, 0x1f])))
		#Read plant data
		data=requester.read_by_handle(0x0035)[0]
		temperature, sunlight, moisture, fertility = unpack('<hxIBHxxxxxx',data)
		msgs.append({'topic': topic + 'Temperatur', 'payload':temperature/10.})
		msgs.append({'topic': topic + 'Helligkeit', 'payload':sunlight})
		msgs.append({'topic': topic + 'Feuchtigkeit', 'payload':moisture})
		msgs.append({'topic': topic + 'Fruchtbarkeit', 'payload':fertility})
    except:
		print "Error during reading:", sys.exc_info()[0]
		filename = '/var/www/html/sensorfehler.txt'
		fehler = sys.exc_info()[0]
		writefile(filename,str(fehler))
		bodensensorfehler += 1
		writefile(bodensensorfehlerdatei,str(bodensensorfehler))		
		if (bodensensorfehler == 5):
			showecho(Jobname,"Fehler","Der Job wurde mit Fehler beendet") 

if (len(msgs) > 0):
	#Schreiben der Werte
	if (debug):
		print "Name..............:",name
		print "MAC-Adress........:",address
		print "Battery level.....:",battery,"%"
		print "Firmware version..:",firmware
		print "Light intensity...:",sunlight,"lux"
		print "Temperatur........:",temperature/10.," C"
		print "Bodenfeuchtigkeit.:",moisture,"%"
		print "Bodenfruchtbarkeit:",fertility,"uS/cm"
	#Battery level
	filename = '/var/www/html/battery.txt';
	writefile(filename,str(battery))
	#sunlight
	filename = '/var/www/html/sunlight.txt';
	writefile(filename,str(sunlight))
	#sunlight
	filename = '/var/www/html/sunlight.txt';
	writefile(filename,str(sunlight))
	#Bodenfeuchtigkeit
	wert = moisture
	filemax = '/var/www/html/bodenfeuchtemax.txt';
	filemin = '/var/www/html/bodenfeuchtemin.txt';
	filenow = '/var/www/html/bodenfeuchte.txt';
	#Einlesen der IST Werte
	#MAX
	wertmax = readfile(filemax)
	if not (wertmax == "x"):
		wertmax = float(wertmax)
	#MIN
	wertmin = readfile(filemin)
	if wertmin != "x":
		wertmin = float(wertmin)
	#Vergleich
	#ist MIN > NOW
	if ((wertmin > wert ) or (wertmin == "x")):
		writefile(filemin,str(wert))
	#ist NOW > MAX
	if ((wert > wertmax) or (wertmax == "x")):
		writefile(filemax,str(wert))
	#schreibe die jetzt Temp ins File
	writefile(filenow,str(wert))
	#fertility
	wert = fertility
	filemax = '/var/www/html/fertilitymax.txt';
	filemin = '/var/www/html/fertilitymin.txt';
	filenow = '/var/www/html/fertility.txt';
	#Einlesen der IST Werte
	#MAX
	wertmax = readfile(filemax)
	if not (wertmax == "x"):
		wertmax = float(wertmax)
	#MIN
	wertmin = readfile(filemin)
	if wertmin != "x":
		wertmin = float(wertmin)
	#Vergleich
	#ist MIN > NOW
	if ((wertmin > wert ) or (wertmin == "x")):
		writefile(filemin,str(wert))
	#ist NOW > MAX
	if ((wert > wertmax) or (wertmax == "x")):
		writefile(filemax,str(wert))
	#schreibe die jetzt Temp ins File
	writefile(filenow,str(wert))
	#Schreibe in SQL DB
	sql_query = "INSERT INTO pflanzensensor VALUES (now(), "+str(battery)+","+str(sunlight)+","+str(temperature/10.)+","+str(moisture)+","+str(fertility)+");"
	if debug:
		print sql_query
	#mysql_query(sql_query)
	#setze Fehlerdatei zurück
	writefile(bodensensorfehlerdatei,str(0))		


	
	#publish.multiple(msgs, hostname="localhost", port=1883, client_id="miflower", keepalive=60,will=None, auth=None, tls=None)
	for msg in msgs:
		publish.single(msg['topic'], payload=msg['payload'], hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)
