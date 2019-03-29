#!/bin/bash

umount /fritz.nas

mount -t cifs -o username='**yourUsername**',password='**yourPassword**',uid=1000,gid=1000,sec=ntlmv2 //192.168.10.1/fritz.nas/Sharkoon-Flexi-DriveEC1-01 /fritz.nas

cd /usr/script

OUTPUT_FILE=/fritz.nas/poolcontroller/datenbankbackup-$(date +%Y%m%d).bz2
DATABASE_NAME="**yourDatabase**"

mysqldump --defaults-file=.my.cnf $DATABASE_NAME | bzip2 > $OUTPUT_FILE 
