#!/bin/bash

# VARIABLEN - HIER EDITIEREN
BACKUP_PFAD="/fritz.nas"
BACKUP_ANZAHL="5"
BACKUP_NAME="RaspberryPiBackup"
DIENSTE_START_STOP="service mysql"
# ENDE VARIABLEN

umount /fritz.nas

mount -t cifs -o username='**yourUsername**',password='**yourPassword**',uid=1000,gid=1000,sec=ntlmv2 //192.168.*.*/fritz.nas/Sharkoon-Flexi-DriveEC1-01 /fritz.nas

cd /usr/script


# Stoppe Dienste vor Backup
#${DIENSTE_START_STOP} stop

# Backup mit Hilfe von dd erstellen und im angegebenen Pfad speichern
dd if=/dev/mmcblk0 of=${BACKUP_PFAD}/${BACKUP_NAME}-$(date +%Y%m%d-%H%M%S).img bs=1MB

# Starte Dienste nach Backup
${START_SERVICES} start

# Alte Sicherungen die nach X neuen Sicherungen entfernen
pushd ${BACKUP_PFAD}; ls -tr ${BACKUP_PFAD}/${BACKUP_NAME}* | head -n -${BACKUP_ANZAHL} | xargs rm; popd