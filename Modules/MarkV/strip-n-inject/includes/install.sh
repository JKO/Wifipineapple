#!/bin/sh

installed="0"

# install deps
opkg remove twisted-web --force-depends && opkg update && opkg install twisted-web && installed="1"

if [ ! -e "/usr/lib/python2.7/site-packages/OpenSSL" ]; then
  ln -s /sd/usr/lib/python2.7/site-packages/OpenSSL /usr/lib/python2.7/site-packages/
fi

if [ ! -e "/usr/lib/python2.7/site-packages/twisted/web" ]; then
  ln -s /sd/usr/lib/python2.7/site-packages/twisted/web /usr/lib/python2.7/site-packages/twisted/
fi

if [ "${installed}" == "1" ]; then
  touch installed
fi
