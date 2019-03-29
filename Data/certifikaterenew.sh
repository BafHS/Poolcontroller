#!/bin/bash
/etc/init.d/apache2 stop
/home/pi/letsencrypt/letsencrypt-auto renew
/etc/init.d/apache2 start
