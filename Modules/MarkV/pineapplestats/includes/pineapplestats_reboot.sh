#!/bin/bash

LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/sd/lib:/sd/usr/lib
PATH=$PATH:/sd/usr/bin:/sd/usr/sbin

MYPATH="$(dirname $0)/"
LOG=${MYPATH}log

echo -e "==================================" >> ${LOG}
echo -e "REBOOT..." >> ${LOG}

MYTIMESTAMP=`date +%s`
MYDATE=`date -d @${MYTIMESTAMP} +"%y-%m-%d %k-%M-%S"`

echo -e "Timestamp: ${MYDATE}" >> ${LOG}

echo -e "==================================\n" >> ${LOG}

reboot