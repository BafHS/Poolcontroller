#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
# 
# In dieser Datein stehe alle notwendigen Parameter
# jedes Script includiert dieses Dokument
# 
#globale Variablen
globalversion = "6.0"
globalversiondate = "11.03.2019"
versionsettings = globalversion +" vom " +globalversiondate


#Belegung BCM
# BCM	Wo	
# 0		Relais 0	Poolpumpe
GPIOpoolpumpe = 0
MQTTpoolpumpe = "Garten/Pool/Pumpe"
# 1		Relais 1	Solarbypass
GPIObypass = 1
MQTTbypass = "Garten/Pool/Solarbypass"
# 2		Relais 2	UWS
GPIOuws = 2
MQTTuws = "Garten/Lampe/UWS"
# 3		Relais 3	Kugellampe
GPIOlampe = 3
MQTTlampe = "Garten/Lampe/Kugel"
# 4		Relais 4	Spot
GPIOspot = 4
MQTTspot = "Garten/Lampe/Spot"
# 5		Relais 5	Wasserpumpe
GPIOgartenpumpe = 5
MQTTgartenpumpe = "Garten/Beregnung/Pumpe"
# 6		Relais 6	Gardena Magnetventil
GPIOmagnetventil = 6
MQTTmagnetventil = "/Garten/Beregnung/Magnetventil"
# 7		Relais 7	Schaukel
GPIOschaukel = 7
MQTTschaukel = "Garten/Lampe/Schaukel" 
# 8		CE			MCP3820	
# 9		MOSI		MCP3820
# 10	MISO		MCP3820
# 11	SCLK		MCP3820
# 12	Sommer
GPIOsummer = 12
# 13	reinigen
GPIOreinigen = 13
MQTTreinigen = "Garten/Pool/Reinigen"
# 14	frei
GPIOfiltern = 14
MQTTfiltern = "Garten/Pool/Filtern"
# 15	D4			HD44780
# 16	D5			HD44780
# 17	D6			HD44780
# 18	D7			HD44780
# 19	RS			HD44780
# 20	E			HD44780
# 21	433 receiver	
# 22	433 sender	
# 23	3,3 V ??? A	HD44780
GPIOdisplaybacklight = 23
# 24	Automatic
GPIOautomatic = 24
# 25	DS18B20	
GPIOautomaticberegnung = 26
GPIOsummerberegnung = 27
#SQL Benutzer
SQL_DB = 				"**yourDatabase"
SQL_User_Select =		"**yourUsernameSelect"
SQL_Password_Select =	"**yourPassword"
SQL_User_Insert =		"**yourUsernameInsert"
SQL_Password_Insert =	"**yourPassword"
#MQTT Server
MQTTServer = '192.168.10.50'
#MQTT definitionen
MQTTbodenwerte = "Garten/Boden"
MQTTtemperaturen = "Garten/Pool"
MQTTpoolcontroller = "Garten/Pool/Controller/Status" 
MQTTkreislaufaktiv = "Garten/Beregnung/Druck/aktiv"
MQTTkreislaufdruck = "Garten/Beregnung/Druck/Kanal"
# Daten der Temperatursensoren DS18B20
w1vorlauf =    "28-0000070347d8"
w1ruecklauf =  "28-00000703bf24"
w1solar =      "28-00000703f6c7"
w1outdoor =    "28-0000070401b2"
w1schuppen =   "28-00000703d304"
#Daten der Xiaomi Mi plant sensor
pflanzensensor1 = "C4:7C:8D:65:57:0D"
pflanzensensor2 = "C4:7C:8D:65:5F:0E"
#Bodenfeuchtigkeit Trigger
bodenfeuchtigkeitsoll = 46
#Werte Hysterese
#tempdiff = intval("2")
#maxpool  = intval("29")	
tempdiff = 2
lowpool = 24
maxpool  = 25
differenzsoll = 0.4
#durchlaufwarte Zeit Minuten
durchlauf = 17   	#Poolcontroller ca 3 Stunden
wait 	  = 10 * 60 #Minuten je Durchlauf in Poolcontroller
#Zeit Belimo in sekunden
belimo = 150
#Solar und Pumpe nur in der Zeit von morgens bis abends
morgens = "7:00"
abends  = "18:00"
#Trigger wait in sekunden
trigger = 2  #Sekunden
#Trigger Lang in sekunden
triggerlong = 60  #Sekunden
#Trigger Beregnung wait in sekunden
triggerberegnung = 10  #Sekunden
#Dauer Nachtlich bei Dunkelheit
nachtlicht = 2  #Stunden
#daily pumptime in Stunden
dauerabend = 1  #Stunden
dauermittag = 1  #Stunde
#Beregnungsdauer
kreislauf1 = 30  #Minuten
kreislauf2 = 30  #Minuten
kreislauf3 = 30  #Minuten
kreislauf4 = 30  #Minuten
kreislauf5 = 30  #Minuten
#Beregnungsdauer
kreislaufmorgens1 = 20 #Minuten
kreislaufmorgens2 = 20 #Minuten
kreislaufmorgens3 = 20 #Minuten
kreislaufmorgens4 = 20 #Minuten
kreislaufmorgens5 = 20 #Minuten
#Beregnungsdauer
kreislaufmittags1 = 20 #Minuten
kreislaufmittags2 = 20 #Minuten
kreislaufmittags3 = 20 #Minuten
kreislaufmittags4 = 20 #Minuten
kreislaufmittags5 = 20 #Minuten
#Anzahl der Abfragen nach Druckaus
NachAusAbfrage = 15
#Druck zu hoch im Sandfilter
sandfilterdruckwarnung = 1.1
#Abfragen
#Verzoegerung am Display vor neuem Inhalt
displaydelay = 5
#Verzoegerung der Sensor Abfrage
sensordelay = 30
#MCP3208 AD Wandler
volt = 5

####aber hier wird nicht mehr gelesen
ENDEderWERTE = "ende"




# Define GPIO to LCD mapping
LCD_RS = 19 #7
LCD_E = 20 #8
LCD_D4 = 15 #25
LCD_D5 = 16 #24
LCD_D6 = 17 #23
LCD_D7 = 18 #18
LED_ON = 23 

# Define some device constants
LCD_WIDTH = 20 # Maximum characters per line
LCD_CHR = True
LCD_CMD = False

LCD_LINE_1 = 0x80 # LCD RAM address for the 1st line
LCD_LINE_2 = 0xC0 # LCD RAM address for the 2nd line
LCD_LINE_3 = 0x94 # LCD RAM address for the 3rd line
LCD_LINE_4 = 0xD4 # LCD RAM address for the 4th line

# Timing constants
E_PULSE = 0.0005
E_DELAY = 0.0005

#Import
import mysql.connector	# MySQL Python Connect importieren
from mysql.connector import Error	# Error von MySQL importieren
import RPi.GPIO as GPIO
import time
import spidev           # SPI-Dev Library
from time import sleep  # sleep importieren
import paho.mqtt.publish as publish

#open Spidev
global spi

#open spidev on Programstart
def OpenSpiDev():
	global spi
	#open SPI
	spi = spidev.SpiDev()
	spi.open(0,0)

#Auslesen des MCP3208
def ReadAnalogKanal(channel):
	global spi
	OpenSpiDev()
	adc = spi.xfer2([4 | 2 | (channel >> 2), (channel & 3) << 6, 0])
	data = ((adc[1]&15) << 8) + adc[2]
	data=(data * volt) / float(4096)
	data = data - 0.7	
	data=round(data,1)
	if (data < 0.1):
		data = 0
	channelnow = '/var/www/html/Kanal'+str(channel)+'.txt';
	writefile(channelnow,str(data))
	#MAX
	channelmax = '/var/www/html/Kanal'+str(channel)+'max.txt';
	druckmax = readfile(channelmax)
	if not (druckmax == "x"):
		druckmax = float(druckmax)
	#Vergleich
	#ist NOW > MAX
	if ((data > druckmax) or (druckmax == "x")):
		writefile(channelmax,str(data))
	#MQTT Publish Anfang	
	MQTTTopic = MQTTkreislaufdruck +str(channel)
	#client.publish(MQTTTopic, data ,qos=0,retain=True)	
	publish.single(MQTTTopic, payload=data, hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)
	#Rueckgabe
	return data
	

#Auslesen des MCP3208
def ReadAnalogInput(channel):
	adc = spi.xfer2([4 | 2 | (channel >> 2), (channel & 3) << 6, 0])
	data = ((adc[1]&15) << 8) + adc[2]
	data=(data * volt) / float(4096)
	data=round(data,1)
	channelnow = '/var/www/html/Kanal'+str(channel)+'.txt';
	writefile(channelnow,str(data))
	return data

#Abfrage CPU Temperatur
def getCpuTemperature():  
	tempFile = open( "/sys/class/thermal/thermal_zone0/temp" )  
	cpu_temp = tempFile.read()  
	tempFile.close()
	cpu_temp=float(cpu_temp)/1000
	rueckgabewert = round(cpu_temp,1)
	#rueckgabewert = '%6.1f' % cpu_temp
	return(rueckgabewert)

#Abfrage DS18B20Temperatur
def aktuelleTemperatur(sensor):
	#sensor = "28-00000703f6c7"
	# 1-wire Slave Datei lesen
	file = open('/sys/bus/w1/devices/' + sensor +'/w1_slave')
	filecontent = file.read()
	file.close()
	# Temperaturwerte auslesen und konvertieren
	stringvalue = filecontent.split("\n")[1].split(" ")[9]
	temperature = float(stringvalue[2:]) / 1000
	# Temperatur ausgeben
	rueckgabewert = '%4.1f' % temperature
	rueckgabe = round(temperature,1)
	return(rueckgabe)

#Finde aktiven Beregnungskreislauf
def findKreislauf():
	#warte Zeit in Sekunden
	time.sleep(triggerberegnung)
	#default
	kreis=4
	#Auslesen Druck Kanal 1
	kreis1=float(readfile('/var/www/html/Kanal1.txt'))
	#Auslesen Druck Kanal 2
	kreis2=float(readfile('/var/www/html/Kanal2.txt'))
	#Auslesen Druck Kanal 3
	kreis3=float(readfile('/var/www/html/Kanal3.txt'))
	#Auslesen Druck Kanal 4
	kreis4=float(readfile('/var/www/html/Kanal4.txt'))
	#print "global"
	if (kreis1 > 0.8):
		kreis = 1
	if (kreis2 > 0.8):
		kreis = 2
	if (kreis3 > 0.8):
		kreis = 3
	print "Kreis1 "+str(kreis1)
	print "kreis2 "+str(kreis2)
	print "kreis3 "+str(kreis3)
	print "kreis4 "+str(kreis4)
	print "Kreis  "+str(kreis)	
	#Schreibe Status
	writefile('/var/www/html/Kreislauf.txt',str(kreis))
	#MQTT Publish Anfang	
	MQTTTopic = MQTTkreislaufaktiv
	publish.single(MQTTTopic, payload=kreis, hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)
	return(kreis)
	
#MQTT publish eines Wertes
def mqqtsinglepublish(topic,data,retain,):
	#MQTT
	publish.single(topic, payload=data, hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)
	
#MQTT last will and testament
def mqqtpublishlwt(topic,data,retain):
	#MQTT
	publish.single(topic, payload=data, hostname=MQTTServer, port=1883, keepalive=60,will=None, auth=None, tls=None)

	
	
#Debug bzw Syslog Message
def showecho(job, info, longtext):
	try:
		# Verbindung zur DB herstellen    
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Insert, passwd=SQL_Password_Insert, db=SQL_DB) 
		# Cursorfunktion in Variable schreiben    
		dbcursor = dbconnect.cursor()
		#Change ' zu "
		#longtexttext=str_replace(chr(39),chr(34),longtext);
		longtext = longtext.replace(chr(39),chr(34))
		sql_query = "insert into poollog (job,status,text) values (%s,%s,%s)"
		#die Argumente
		args= (job, info, longtext)
		# Ausfueheren eines Befehls z.B select * from poolstatus
		dbcursor.execute(sql_query, args)
		#Bestaetigen der Transaktion
		dbconnect.commit()
	except Error as e:
		print(e)
	finally:
		dbcursor.close()
		dbconnect.close()

#Change Bootdate
def change_boottime(bootdate):
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Insert, passwd=SQL_Password_Insert, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		# Ausfueheren eines Befehls z.B select * from poolstatus
		sqlquery = "UPDATE poolstatus SET boottime='"+bootdate+"';"
		dbcursor.execute(sqlquery)
		#Bestaetigen der Transaktion
		dbconnect.commit()

	except Error as e:
		print(e)

	finally:
		dbcursor.close()
		dbconnect.close()
		
#Sommerbetrieb?
def read_boottime():
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Select, passwd=SQL_Password_Select, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		# Ausfueheren eines Befehls z.B select * from poolstatus
		sqlquery = "select boottime from poolstatus;"
		dbcursor.execute(sqlquery)
		row = dbcursor.fetchone()
		boottime = row[0]
		return boottime
	except Error as e:
		print(e)

	finally:
		dbcursor.close()
		dbconnect.close()

#Lese Parameter aus der Settings SQL DB
def read_settings(parameter):
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Select, passwd=SQL_Password_Select, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		# Ausfueheren eines Befehls z.B select * from poolstatus
		sqlquery = "select " + parameter +" from poolsettings;"
		dbcursor.execute(sqlquery)
		row = dbcursor.fetchone()
		setting_value = row[0]
		return setting_value
	except Error as e:
		print(e)

	finally:
		dbcursor.close()
		dbconnect.close()
#Lese Bodenfeuchtigkeit aus
def read_bodenwerte():
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Select, passwd=SQL_Password_Select, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		# Ausfueheren eines Befehls z.B select * from poolstatus
		sqlquery = "select datum, feuchtigkeit from pflanzensensor order by datum desc limit 1;"
		dbcursor.execute(sqlquery)
		row = dbcursor.fetchone()
		bodendatum=row[0]
		bodenwert=row[1]
		return (bodendatum,bodenwert)
	except Error as e:
		print(e)
	finally:
		dbcursor.close()
		dbconnect.close()
		
#Insert Statemant MySQL
def mysql_query(sqlquery):
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Insert, passwd=SQL_Password_Insert, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		dbcursor.execute(sqlquery)
		#bestaetigen
		dbconnect.commit()
		return
	except Error as e:
		print(e)

	finally:
		dbcursor.close()
		dbconnect.close()
#Insert Statemant MySQL
def mysql_procedure(procedure,sensor,wert):
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Insert, passwd=SQL_Password_Insert, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		#Aufbau der Argumente
		args = [sensor,wert]
		#Ausfueheren der Procedur
		result_args = dbcursor.callproc(procedure, args)
		#Bestaetigen der Transaktion
		dbconnect.commit()
		return
	except Error as e:
		print(e)
		showecho(jobname,"Fehler",e)
	finally:
		dbcursor.close()
		dbconnect.close()
#Insert Statemant MySQL
def mysql_procedureresetdata():
	try:
		# Verbindung zur DB herstellen
		dbconnect = mysql.connector.connect(host="localhost", user=SQL_User_Insert, passwd=SQL_Password_Insert, db=SQL_DB)
		# Cursorfunktion in Variable schreiben
		dbcursor = dbconnect.cursor()
		#Ausfueheren der Procedur
		result_args = dbcursor.callproc('resetstatus')
		#Bestaetigen der Transaktion
		dbconnect.commit()
		return
	except Error as e:
		print(e)
		showecho(jobname,"Fehler",e)
	finally:
		dbcursor.close()
		dbconnect.close()

#Lesen der datei
def readfile(filename):
	try:
		datei=open(filename,"r")
		temp = datei.read()
		datei.close()
		return(temp)
	except:
		datei=open(filename,"w")
		datei.write("x")
		datei.close()
		return("x")

#Schreiben in Datei
def writefile(filename,temp):
	datei=open(filename,"w")
	datei.write(temp)
	datei.close()


########################################
#function to send a mail#
########################################
# import required modules
from email.mime.text import MIMEText
import smtplib
import sys

# mail address of the sender
sender = '**yourAdress'

# fqdn of the mail server
smtpserver = 'smtp.strato.de:587'

# username for the SMTP authentication
smtpusername = '**yourUsername'

# password for the SMTP authentication
smtppassword = '**yourPassword'

# use TLS encryption for the connection
usetls = True
#Send Mail
def sendmail(recipient,subject,content):

	# generate a RFC 2822 message
	msg = MIMEText(content)
	msg['From'] = sender
	msg['To'] = recipient
	msg['Subject'] = subject

	# open SMTP connection
	server = smtplib.SMTP(smtpserver)

	# start TLS encryption
	if usetls:
		server.starttls()

	# login with specified account
	if smtpusername and smtppassword:
		server.login(smtpusername,smtppassword)

	# send generated message
	server.sendmail(sender,recipient,msg.as_string())

	# close SMTP connection
	server.quit()
#
	
	
#Routinen fuer Display HD44780
def lcd_init():
	# Initialise display
	lcd_byte(0x33,LCD_CMD) # 110011 Initialise	
	lcd_byte(0x32,LCD_CMD) # 110010 Initialise
	lcd_byte(0x06,LCD_CMD) # 000110 Cursor move direction
	lcd_byte(0x0C,LCD_CMD) # 001100 Display On,Cursor Off, Blink Off
	lcd_byte(0x28,LCD_CMD) # 101000 Data length, number of lines, font size
	lcd_byte(0x01,LCD_CMD) # 000001 Clear display
	time.sleep(E_DELAY)

def lcd_byte(bits, mode):
	# Send byte to data pins
	# bits = data
	# mode = True for character
	#        False for command
	GPIO.output(LCD_RS, mode) # RS
	# High bits
	GPIO.output(LCD_D4, False)
	GPIO.output(LCD_D5, False)
	GPIO.output(LCD_D6, False)
	GPIO.output(LCD_D7, False)
	if bits&0x10==0x10:
		GPIO.output(LCD_D4, True)
	if bits&0x20==0x20:
		GPIO.output(LCD_D5, True)
	if bits&0x40==0x40:
		GPIO.output(LCD_D6, True)
	if bits&0x80==0x80:
		GPIO.output(LCD_D7, True)
	# Toggle 'Enable' pin
	lcd_toggle_enable()
	# Low bits
	GPIO.output(LCD_D4, False)
	GPIO.output(LCD_D5, False)
	GPIO.output(LCD_D6, False)
	GPIO.output(LCD_D7, False)
	if bits&0x01==0x01:
		GPIO.output(LCD_D4, True)
	if bits&0x02==0x02:
		GPIO.output(LCD_D5, True)
	if bits&0x04==0x04:
		GPIO.output(LCD_D6, True)
	if bits&0x08==0x08:
		GPIO.output(LCD_D7, True)
	# Toggle 'Enable' pin
	lcd_toggle_enable()

def lcd_toggle_enable():
	# Toggle enable
	time.sleep(E_DELAY)
	GPIO.output(LCD_E, True)
	time.sleep(E_PULSE)
	GPIO.output(LCD_E, False)
	time.sleep(E_DELAY)
	
def lcd_string(message,line,style):
	# Send string to display
	# style=1 Left justified
	# style=2 Centred
	# style=3 Right justified

	if style==1:
		message = message.ljust(LCD_WIDTH," ")
	elif style==2:
		message = message.center(LCD_WIDTH," ")
	elif style==3:
		message = message.rjust(LCD_WIDTH," ")

	lcd_byte(line, LCD_CMD)

	for i in range(LCD_WIDTH):
		lcd_byte(ord(message[i]),LCD_CHR)

def lcd_backlight(flag):
	# Toggle backlight on-off-on
	GPIO.output(LED_ON, flag)
# #Soll die Umlaute durch anzeigbare Zecihen ersetzen klappt nicht so. 
# def kill_umlauts(message):
	# try:
		# message = message.encode('utf-8')
		# message = message.replace('ä', chr(225))
		# message = message.replace('ö', chr(239))
		# message = message.replace('ü', chr(245))
		# message = message.replace('Ä', chr(225))
		# message = message.replace('Ö', chr(239))
		# message = message.replace('Ü', chr(245))
		# message = message.replace('ß', chr(226))
		# message = message.replace('°', chr(223))
		# message = message.replace('µ', chr(228))
		# message = message.replace('´', chr(96))
		# message = message.replace('?', chr(227))
		# message = message.replace('-', '-')
		# message = message.replace('"', '"')
		# message = message.replace('"', '"')
		# message = message.replace('"', '"')
# #		message = message.replace(''', '\'')
# #		message = message.replace(''', '\'')
	# except:
		# return message;
	# return message

