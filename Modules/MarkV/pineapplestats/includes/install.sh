#!/bin/sh

MODULEPATH="$(dirname $0)/"

ping -c 3 8.8.8.8 >/dev/null
rc=$?
if [[ $rc -ne 0 ]]; then
	touch ${MODULEPATH}install_error

	echo "done" > ${MODULEPATH}status.php
else
	# Update repository
	opkg update

	# curl 
	opkg install curl

	# tcpdump
	opkg install tcpdump
	
	#libpcap
	opkg upgrade libpcap
	
	# check permissions
	chmod +x ${MODULEPATH}pineapplestats_report.sh
	chmod +x ${MODULEPATH}pineapplestats_token.sh
	chmod +x ${MODULEPATH}pineapplestats_reboot.sh
	chmod +x ${MODULEPATH}pineapplestats_watchdog.sh
	
	# Done !
	touch ${MODULEPATH}installed
	echo "done" > ${MODULEPATH}status.php
fi