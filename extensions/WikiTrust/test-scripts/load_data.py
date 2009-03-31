#!/usr/bin/python

"""
Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Ian Pye, Luca de Alfaro

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice,
this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.

3. The names of the contributors may not be used to endorse or promote
products derived from this software without specific prior written
permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

"""

## sets up a test run
import MySQLdb
import sys
import getopt
import os
import ConfigParser

## const globals
MW_DUMPER = "java -Xmx600M -server -jar mwdumper.jar --format=sql:1.5"
DB_ENGINE = "mysql"
BASE_DIR = "./"   
INI_FILE = BASE_DIR + "db_access_data.ini"

## Usage method
def usage():
  print "Usage: python load_data.py [-h, --help, --clear_db] dump1 dump2 ... dumpn "


## A list of files to load
dumps = []

def load_dump(dump): 
        
  global ini_config

  # Load the xml file into the sender db
  os.system(MW_DUMPER + " " + dump + " | " + DB_ENGINE + " -u " +
      ini_config.get('db', 'user') + " -p" + ini_config.get('db', 'pass') + " " +
      ini_config.get('db', 'db'))

  return

try:
  opts, args = getopt.gnu_getopt(sys.argv[1:], "h", ["help", "clear_db"])
except getopt.GetoptError:
  # print help information and exit:
  usage()
  sys.exit(2)

do_clear = False
for a in args:
  dumps.append(a)
for o, a in opts:
  if o in ("-h", "--help"):
    usage()
    sys.exit(2)
  if o in ("--clear_db"):
    do_clear = True
## parse the ini file
ini_config = ConfigParser.ConfigParser()
ini_config.readfp(open(INI_FILE))

## init the DB
connection = MySQLdb.connect(host=ini_config.get('db', 'host'),
user=ini_config.get('db', 'user'), passwd=ini_config.get('db', 'pass') \
    , db=ini_config.get('db', 'db') )
curs = connection.cursor()

# clear out the pull db if requested
if do_clear: 
  curs.execute("delete from text")     
  curs.execute("delete from page")     
  curs.execute("delete from revision")
  connection.commit()

for dump in dumps:
  load_dump(dump) 

