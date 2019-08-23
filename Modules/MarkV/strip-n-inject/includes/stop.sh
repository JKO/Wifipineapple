#!/bin/bash

# kill sslstrip
killall -9 python

# remove the log
rm /sd/tmp/proxy_inject.log

# run it a few times incase were in an unexpected state
iptables -t nat -D PREROUTING $(iptables -L -t nat --line-numbers | grep 10000 | awk '{print $1}')
iptables -t nat -D PREROUTING $(iptables -L -t nat --line-numbers | grep 10000 | awk '{print $1}')
iptables -t nat -D PREROUTING $(iptables -L -t nat --line-numbers | grep 10000 | awk '{print $1}')
iptables -t nat -D  PREROUTING 2
iptables -t nat -D PREROUTING 2
iptables -t nat -D PREROUTING 2
iptables -t nat -D PREROUTING 2


# exit no error
exit 0
