#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
#Job jeden Tag um Mitternacht
#Löschen vonn Werten in der SQL DB

#locale version
localversion = "1.1 vom 22.08.2017"


#import
import os, sys, time
#import RPi.GPIO as GPIO
#import spidev           # SPI-Dev Library
from datetime import datetime, date, timedelta
#from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *
#Jobname
Jobname = os.path.basename(sys.argv[0])

#Start
showecho(Jobname,"Normal","Reset aller Werte "+localversion)

#Connect SQL fuer LoeschenDebug
dbconnect = mysql.connector.connect(host="localhost", user="pool_delete", passwd="pooldelete", db="knappe") 
# Cursorfunktion in Variable schreiben    
dbcursor = dbconnect.cursor()
#löschen der Log Einträge älter als 5 tage
sql_query = "DELETE FROM poollog WHERE datum < DATE_SUB(NOW(), INTERVAL 5 DAY);";
print "SQL "+sql_query
# Ausfueheren eines Befehls z.B select * from poolstatus
dbcursor.execute(sql_query)
#Bestaetigen der Transaktion
dbconnect.commit()

#löschen der Temperatur Einträge älter als 200 tage
sql_query = "DELETE FROM pooltemp WHERE temperaturedate < DATE_SUB(NOW(), INTERVAL 200 DAY);";
print "SQL "+sql_query
# Ausfueheren eines Befehls z.B select * from poolstatus
dbcursor.execute(sql_query)
#Bestaetigen der Transaktion
dbconnect.commit()

#löschen des Pflanzensensors Einträge älter als 200 tage
sql_query = "DELETE FROM pflanzensensor WHERE datum < DATE_SUB(NOW(), INTERVAL 200 DAY);";
print "SQL "+sql_query
# Ausfueheren eines Befehls z.B select * from poolstatus
dbcursor.execute(sql_query)
#Bestaetigen der Transaktion
dbconnect.commit()

dbconnect.close()

showecho(Jobname,"Normal","Reset okay")

