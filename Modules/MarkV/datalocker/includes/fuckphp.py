#!/usr/bin/python

"""
PHP was pissing me off with trying to do a sha512 hash
so I am writting this quick python script to do what i need.
FUCK YOU PHP
PYTHON 4 LIFE

-Newbi3

"""

import sqlite3
import hashlib
import sys

def padKey(length, key):
        """ This function checks if the key length is long enough """
        if len(key) != length:
                padding = "`"
                padLen = (length - len(key)%length) % length
                key = padding*(padLen/2)+key+padding*(padLen-padLen/2)
                return key
        else:
                #print red + "Your key must be " + str(length) + " characters long not " + str(len(key)) + "!" + reset
                return key

def fuckPHP(args):
	mode = args[1]
	file = args[2]
	key = args[3]

	if mode == "aes256":
		key = padKey(32, key)
	elif mode == "aes128":
		key = padKey(16, key)

	try:
		newHash = hashlib.sha512(file + key).hexdigest()
		conn = sqlite3.connect("/pineapple/components/infusions/datalocker/includes/database/tracker.db")
	        c = conn.cursor()
	        c.execute("SELECT key FROM tracking WHERE file == '" + file + "'")
		hashedKey = c.fetchone()
		conn.close()

		if hashedKey[0] != "":
			if newHash == hashedKey[0]:
				print "good"
			else:
				print "bad"
		else:
			print "good"
	except:
		print "good"


fuckPHP(sys.argv)
