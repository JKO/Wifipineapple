#!/bin/sh

MODULEPATH="$(dirname $0)/"

opkg remove ettercap
opkg install ${MODULEPATH}dep/ettercap.ipk

sed -i "/redir_command_on = \"iptables/ s/# *//" /etc/etter.conf
sed -i "/redir_command_off = \"iptables/ s/# *//" /etc/etter.conf

sed -i 's/^\(ec_uid = \).*/\10/' /etc/etter.conf
sed -i 's/^\(ec_gid = \).*/\10/' /etc/etter.conf

echo 1 > /proc/sys/net/ipv4/ip_forward

# Done !
touch ${MODULEPATH}installed
echo "done" > ${MODULEPATH}status.php