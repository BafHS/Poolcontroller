Solar Poolcontroller/ Automatische Gartenbew�sserung mit Raspberry PI 


Am Anfang war nur die Idee, eine kosteng�nstige Variante einer Temperatur Differenzregelung mit Internet Zugriff zu bauen.  Steuern der Poolpumpe, des Belimo als Solarbypass, des Unterwasserscheinwerfers (UWS), der Gartenbeleuchtung (Spot und Kugel). Alles mit PHP und MySQL, Apache.

Vor 2 Jahren wurde die Gartenbew�sserung mit integriert, einem Bew�sserungsventil 24 V von Gardena, Magnetventil (Gardena) und mit einem Wasserverteiler (Gardena). Um zu wissen welcher Wasserkreislauf aktiv ist, wurden Drucksensoren verbaut. Daf�r notwendig war ein AD Wandler MCP3820, der ben�tigt Phyton.
Es wurde auch ein Display HD44780 im Schlatkasten eingebaut.

Jetzt wurde das Projekt erweitert mit MQTT um in FHEM integriert zu werden.
Also habt Spa� und nutzt das Projekt.

Viele Gr��e aus Sch�now

Weiter Infos unter install.txt

Map der Verzeichnisse
 
Data/ -> PI /usr/script/

html/ -> PI /var/www/html/

