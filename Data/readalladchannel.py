#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird von startupcontroller.py gestart und liest einmalig alle Werte des AD Wandler
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
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#debug
debug = False
#locale version
localversion = "1.0 vom 15.05.2017"
#Jobname
Jobname = os.path.basename(sys.argv[0])
#debug
debug = True

# #Auslesen des MCP3208
# def ReadAnalogKanal(channel):
	# adc = spi.xfer2([4 | 2 | (channel >> 2), (channel & 3) << 6, 0])
	# data = ((adc[1]&15) << 8) + adc[2]
	# data=(data * volt) / float(4096)
	# data=round(data,1)
	# if (data <= 0.9):
		# data = 0
	# channelnow = '/var/www/html/Kanal'+str(channel)+'.txt';
	# writefile(channelnow,str(data))
	# return data
	
#Funktion auslesen MCP3208
def ReadAnalogChannel():
	#Sammlen der Analog Werte
	druckwasser0=ReadAnalogKanal(0)
	druckwasser1=ReadAnalogKanal(1)
	druckwasser2=ReadAnalogKanal(2)
	druckwasser3=ReadAnalogKanal(3)
	druckwasser4=ReadAnalogKanal(4)
	druckwasser5=ReadAnalogKanal(5)
	druckwasser6=ReadAnalogKanal(6)
	druckwasser7=ReadAnalogKanal(7)
	if debug:
		print ("Druckwasser0  " + str(druckwasser0)+" Druckwasser1  " + str(druckwasser1)+" Druckwasser2  " + str(druckwasser2)+" Druckwasser3  " + str(druckwasser3))
		print ("Druckwasser4  " + str(druckwasser4)+" Druckwasser5  " + str(druckwasser5)+" Druckwasser6  " + str(druckwasser6)+" Druckwasser7  " + str(druckwasser7))

		
#open Spidev
#global spi
#OpenSpiDev()
#spi = spidev.SpiDev()
#spi.open(0,0)
#Frage ab
ReadAnalogChannel()
