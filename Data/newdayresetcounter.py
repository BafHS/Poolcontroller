#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# Dieser Job laeuft jeden Tag Mitternacht und resettet alle Werte

#import
import os, sys, time
import RPi.GPIO as GPIO
import spidev           # SPI-Dev Library
from datetime import datetime, date, timedelta
from time import sleep  # sleep importieren
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import locale
locale.setlocale(locale.LC_TIME, "de_DE") #
# Erweiter den Suchpfad
sys.path.append('//usr//script')
#Import DATEI alles
from globalvar import *

#locale version
localversion = "1.6 vom 01.11.2017"
#Jobname
Jobname = os.path.basename(sys.argv[0])


#main
def main():
	#finde Datum von gestern
	from datetime import date, timedelta
	yesterday = date.today() - timedelta(1)
	gestern=yesterday.strftime('%d.%m%Y')
	#Einlesen der Temperaturen
	poolmin=readfile('/var/www/html/poolmin.txt')
	poolmax=readfile('/var/www/html/poolmax.txt')
	ruecklaufmin=readfile('/var/www/html/ruecklaufmin.txt')
	ruecklaufmax=readfile('/var/www/html/ruecklaufmax.txt')
	solarmin=readfile('/var/www/html/solarmin.txt')
	solarmax=readfile('/var/www/html/solarmax.txt')
	schuppenmin=readfile('/var/www/html/schuppenmin.txt')
	schuppenmax=readfile('/var/www/html/schuppenmax.txt')
	outdoormin=readfile('/var/www/html/outdoormin.txt')
	outdoormax=readfile('/var/www/html/outdoormax.txt')
	#Einlesen Bodenwerte
	bodenfeuchtemax = readfile('/var/www/html/bodenfeuchtemax.txt');
	bodenfeuchtemin = readfile('/var/www/html/bodenfeuchtemin.txt');
	fertilitymax = readfile('/var/www/html/fertilitymax.txt');
	fertilitymin = readfile('/var/www/html/fertilitymin.txt');
	#Einlesen der zeiten
	pumpentime=readfile('/var/www/html/GPIO0.txt')
	solartime=readfile('/var/www/html/GPIO1.txt')
	filtertime=readfile('/var/www/html/GPIO14.txt')
	reinigentime=readfile('/var/www/html/GPIO13.txt')
	# Aufbau SQL Insert 
#	sql_query = "INSERT INTO poolhistory VALUES (current_date()-1, "+poolmin+","+ poolmax +","+ ruecklaufmin +","+ ruecklaufmax +","+ solarmin +","+ solarmax +","+ outdoormin +","+ outdoormax +","+ #schuppenmin +","+ schuppenmax +","+ pumpentime +","+ solartime +","+ reinigentime +","+ filtertime+");"
	sql_query = "INSERT INTO poolhistory VALUES (subdate(current_date, 1), "+poolmin+","+ poolmax +","+ ruecklaufmin +","+ ruecklaufmax +","+ solarmin +","+ solarmax +","+ outdoormin +","+ outdoormax +","+ schuppenmin +","+ schuppenmax +","+ pumpentime +","+ solartime +","+ reinigentime +","+ filtertime+","+ bodenfeuchtemin+","+ bodenfeuchtemax+","+ fertilitymin+","+ fertilitymin+");"
	#print(sql_query)
	mysql_query(sql_query)
	#Schreibe in SQL DB
	mysql_procedureresetdata()
	#Reset datei
	filereset = '/var/www/html/solarmin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/solarmax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/poolmin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/poolmax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/ruecklaufmin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/ruecklaufmax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/outdoormin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/outdoormax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/schuppenmin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/schuppenmax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/bodenfeuchtemax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/bodenfeuchtemin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/fertilitymax.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/fertilitymin.txt';
	a = writefile(filereset,'x')
	filereset = '/var/www/html/kreislauf1.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/kreislauf2.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/kreislauf3.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal0max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal1max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal2max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal3max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal4max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal5max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal6max.txt';
	a = writefile(filereset,'0')
	filereset = '/var/www/html/Kanal7max.txt';
	a = writefile(filereset,'0')
	showecho(Jobname,"Normal","Reset aller Werte "+localversion)

	
#main 
if __name__ == '__main__':
    main()
