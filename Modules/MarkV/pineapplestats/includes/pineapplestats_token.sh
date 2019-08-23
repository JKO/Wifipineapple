#!/bin/bash

LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/sd/lib:/sd/usr/lib
PATH=$PATH:/sd/usr/bin:/sd/usr/sbin

MYPATH="$(dirname $0)/"
LOG=${MYPATH}log

MYSERVER=`cat ${MYPATH}infusion.conf | grep "server" | awk -F = '{print $2}'`
MYTOKEN=`cat ${MYPATH}infusion.conf | grep "token" | awk -F = '{print $2}'`

echo -e "==================================" >> ${LOG}
echo -e "TOKEN..." >> ${LOG}

MYTIMESTAMP=`date +%s`
MYDATE=`date -d @${MYTIMESTAMP} +"%y-%m-%d %k-%M-%S"`

ping -q -c 1 -W 10 8.8.8.8 >/dev/null
rc=$?
if [[ $rc -ne 0 ]]; then
	echo -e "No internet connection... Please check your network connectivity..."
else
	echo -e "Timestamp: ${MYDATE}" >> ${LOG}
	echo -e "Add Pineapple Stats Token: ${MYTOKEN}" >> ${LOG}

	curl -k --data "token=${MYTOKEN}" ${MYSERVER}token.php
fi

echo -e "==================================\n" >> ${LOG}