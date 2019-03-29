#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job wird nur beim Reboot ausgefuehrt.
# liest regelmaessig alle Sensoren und Druckwerte und schreibt alles in die SQL DB


#import der notwendigen Module
import os, sys, time, spidev
import RPi.GPIO as GPIO
import locale
import mysql.connector	# MySQL Python Connect importieren
import paho.mqtt.publish as publish
from datetime import datetime
from time import sleep  # sleep importieren
from mysql.connector import Error	# Error von MySQL importieren
from sys import executable
from subprocess import Popen
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweitere den Suchpfad fuer die Globalen Einstellungen
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#locale version
localversion = "1.9 vom 11.03.2019"
#Jobname
Jobname = os.path.basename(sys.argv[0])

#import syslog
#syslog.openlog( 'myTestLog', 0, syslog.LOG_LOCAL4 )
#syslog.syslog( '%%TEST-6-LOG: Log msg: %s' % 'test msg' )

#Anzeige aktiv
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM) # Use BCM GPIO numbers
#GPIO.setmode(GPIO.BOARD) # Use BCM GPIO numbers
GPIO.setup(LCD_E, GPIO.OUT) # E
GPIO.setup(LCD_RS, GPIO.OUT) # RS
GPIO.setup(LCD_D4, GPIO.OUT) # DB4
GPIO.setup(LCD_D5, GPIO.OUT) # DB5
GPIO.setup(LCD_D6, GPIO.OUT) # DB6
GPIO.setup(LCD_D7, GPIO.OUT) # DB7
#Initialise display
lcd_init()
#Anzeige
lcd_string("Familie Knappe",LCD_LINE_1,2)
lcd_string("Poolcontroller",LCD_LINE_2,2)
lcd_string("wird gestartet",LCD_LINE_3,2)
lcd_string("-> bitte warten <-",LCD_LINE_4,2)


#setzen der GPIO pins 
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM) # Use BCM GPIO numbers
#GPIO.setmode(GPIO.BOARD) # Use BCM GPIO numbers

#GPIO 23 Backlight HD44780  (1=aus 0=ein)
#1=ein Default 
GPIO.setup(GPIOdisplaybacklight,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 8 Automatic  (1=manuel 0=automatic)
#0=automatic Default 
GPIO.setup(GPIOautomatic,GPIO.OUT,initial=GPIO.LOW)
#GPIO 1 Pumpe  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOpoolpumpe,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 1 Bypass  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIObypass,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 2 UWS  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOuws,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 3 Gartenspot  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOspot,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 4 Gartenlampe  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOlampe,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 5 Wasserpumpe  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOgartenpumpe,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 6 Magnetventil  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(GPIOmagnetventil,GPIO.OUT,initial=GPIO.HIGH)
#GPIO 7 frei  (1=OFF 0=ON)
#1=OFF Default 
GPIO.setup(7,GPIO.OUT,initial=GPIO.HIGH)

#warte einfach mal 30 Sekunden
# Auf Netzwerk
# auf SQL Server
#
sleep(30);

#Setze Zeit
os.system('sudo ntpdate -s ptbtime1.ptb.de')
#ermitteln Bootdate in der Form 14.02.2016 23:22
bootdate = (datetime.now().strftime('%d.%m.%y %H:%M'))
#Schreibe in Datei
writefile("/var/www/html/boottime.txt",bootdate)

#log in SQL DB
showecho(Jobname,"Boot","Start "+localversion)

#Schreibe die Startzeit in die SQL DB
change_boottime(bootdate)

#GPIO 12 Sommerbetrieb (1=Sommer 0=Winter)
betriebsart = read_settings("summer") 
#Schreibe in Datei
writefile("/var/www/html/poolsummer.txt",str(betriebsart))
if betriebsart == 0:
	summer=0
	GPIO.setup(GPIOsummer,GPIO.OUT,initial=GPIO.LOW)
	modus="Winterbetrieb"
else:
	summer=1
	GPIO.setup(GPIOsummer,GPIO.OUT,initial=GPIO.HIGH)
	GPIO.setup(GPIOautomatic,GPIO.OUT,initial=GPIO.HIGH)
	modus="Sommerbetrieb"
#GPIO 26 Automatische Beregnung (1=Automatic 0=aus)
betriebsart = read_settings("beregnung") 
#Schreibe in Datei
writefile("/var/www/html/beregnung.txt",str(betriebsart))
if betriebsart == 0:
	beregnung=0
	GPIO.setup(GPIOsummerberegnung,GPIO.OUT,initial=GPIO.LOW)
	GPIO.setup(GPIOautomaticberegnung,GPIO.OUT,initial=GPIO.LOW)
	modusberegnung="Manuell"
else:
	beregnung=1
	GPIO.setup(GPIOsummerberegnung,GPIO.OUT,initial=GPIO.HIGH)
	GPIO.setup(GPIOautomaticberegnung,GPIO.OUT,initial=GPIO.HIGH)
	modusberegnung="Automatisch"

#Start verschiedener Scripte zum Rechnerstart

#starte Display
Popen([executable, '/usr/script/display.py'])
#starte Heartbeat
Popen([executable, '/usr/script/heartbeat.py'])
#starte Auslesen Drucksensoren
#Popen([executable, '/usr/script/readalladchannel.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-0.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-1.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-2.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-3.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-4.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-5.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-6.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-7.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-13.py'])
#starte Kontrolle GPIO Pin x
Popen([executable, '/usr/script/gpioruntime-14.py'])
#starte Abfrage Bodenwerte
Popen([executable, '/usr/script/bodenwerte.py'])

# call sendmail() and generate a new mail with specified subject and content
sendmail('**yourSendAddress','Pollcontroller startet','Version '+localversion+' im '+modus+' startet, Beregnung im Modus '+modusberegnung +'.')

exit()