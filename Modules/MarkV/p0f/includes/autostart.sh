#!/bin/sh

MYPATH="$(dirname $0)/"
MYTIME=`date +%s`

p0f -i br-lan -o ${MYPATH}log/output_${MYTIME}.log &