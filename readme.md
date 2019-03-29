Solar Poolcontroller/ Automatische Gartenbewässerung mit Raspberry PI 


Am Anfang war nur die Idee, eine kostengünstige Variante einer Temperatur Differenzregelung mit Internet Zugriff zu bauen.  Steuern der Poolpumpe, des Belimo als Solarbypass, des Unterwasserscheinwerfers (UWS), der Gartenbeleuchtung (Spot und Kugel). Alles mit PHP und MySQL, Apache.

Vor 2 Jahren wurde die Gartenbewässerung mit integriert, einem Bewässerungsventil 24 V von Gardena, Magnetventil (Gardena) und mit einem Wasserverteiler (Gardena). Um zu wissen welcher Wasserkreislauf aktiv ist, wurden Drucksensoren verbaut. Dafür notwendig war ein AD Wandler MCP3820, der benötigt Phyton.
Es wurde auch ein Display HD44780 im Schlatkasten eingebaut.

Jetzt wurde das Projekt erweitert mit MQTT um in FHEM integriert zu werden.
Also habt Spaß und nutzt das Projekt.

Viele Grüße aus Schönow

Weiter Infos unter install.txt

Map der Verzeichnisse
 
Data/ -> PI /usr/script/

html/ -> PI /var/www/html/

