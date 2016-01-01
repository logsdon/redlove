#!/bin/bash

# specific config variables (EDIT THESE)
HOMEDIR="/etc/var/www.example.com"
FILESDIR="/web/content/subdir"
BACKUPDIR="/backup_folder"
SITENAME="my_site_backup"

DBHOST="my.dbhost.example.com"
DBUSER="MY_DBUSER"
DBPASS="MY_DBPASS"
DBNAME="MY_DBNAME"

EMAIL="me@mail.com"

# other config variables(DO NOT EDIT THESE)
MYSQLDUMP="$(which mysqldump)"
NOWDATE=$(date +"%Y%m%d-%H%M%S")
NOWDAY=$(date +"%d")
TARGETPATH=$HOMEDIR$BACKUPDIR/$NOWDAY

# check to see if target path exists - if so, delete the old one and create a new one, otherwise just create it
if [ -d $TARGETPATH ]
then
rm -r $TARGETPATH
mkdir -p $TARGETPATH
else
mkdir -p $TARGETPATH
fi

# create a GZIP of the directory inside the target path
tar -czPf $TARGETPATH/${SITENAME}__$NOWDATE.tar.gz $HOMEDIR$FILESDIR

# dump the data into a SQL file inside the target path
$MYSQLDUMP -h $DBHOST -u $DBUSER -p$DBPASS $DBNAME | gzip > $TARGETPATH/${SITENAME}__${DBNAME}__$NOWDATE.sql.gz

# email the GZIP files
# mutt $EMAIL -a $TARGETPATH/${SITENAME}_$NOWDATE.tar.gz -a $TARGETPATH/${SITENAME}__${DBNAME}_$NOWDATE.sql.gz -s "FULL Backup for $SITENAME"

# print a message for the logfile / output email
printf "$SITENAME has been backed up" | tee -a $LOGFILE

# Task Name: Site Backup - My Site
# Schedule: Every day at 03:00 AM
# Command Language: perl
# Command: /etc/var/www.example.com/backup_folder/backup-script.sh
