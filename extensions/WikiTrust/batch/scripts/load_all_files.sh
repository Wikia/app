#!/bin/bash

# Copyright (c) 2007-2008 The Regents of the University of California
# All rights reserved.
#
# Authors: Ian Pye
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions are met:
#
# 1. Redistributions of source code must retain the above copyright notice,
# this list of conditions and the following disclaimer.
#
# 2. Redistributions in binary form must reproduce the above copyright notice,
# this list of conditions and the following disclaimer in the documentation
# and/or other materials provided with the distribution.
#
# 3. The names of the contributors may not be used to endorse or promote
# products derived from this software without specific prior written
# permission.
#
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
# AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
# LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
# CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
# SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
# INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
# CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
# ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
# POSSIBILITY OF SUCH DAMAGE.


USER="wikiuser"
PASS=$3
LOADER="java -Xmx600M -server -jar $4/mwdumper.jar --format=sql:1.5"
DB_ENGINE="mysql -u $USER -p$PASS"
DB="$2"
COLORED_WIKI_DIR=$1

NUM_FILES_TO_BATCH=1
KEEP_RUN_FILE="/home/ipye/keep_running"
SLEEP_TIME=1;

E_BADARGS=65
E_BADDIR=66

if [ ! -n "$1" -o ! -n "$2" ]
then
  echo "Usage: `basename $0` <dir> <dbname> <pass> <path-to-mwdumper> (<loader>, (<db client>)), where dir is where to find the colored wikis"
  echo "       dbname is the name of the db to add pages to"
  echo "       loader is the xml loading program (default mwdumper)"
  echo "       db is the db to add the pages to (default mysql)"
  exit $E_BADARGS
fi  

if [ ! -d "$COLORED_WIKI_DIR" ]
then
  if [ -e "$COLORED_WIKI_DIR" ]
  then
    echo "single file mode"
    `$LOADER $COLORED_WIKI_DIR | $DB_ENGINE $DB`
    exit 0
  fi
  echo "direcory $COLORED_WIKI_DIR does not exist"
  exit $E_BADDIR
fi

if [ -n "$5" ]
then
  LOADER="$5"
fi

if [ -n "$6" ]
then
  DB_ENGINE="$6"
fi


echo "loading all files in $COLORED_WIKI_DIR with $LOADER into $DB_ENGINE $DB"
cd $COLORED_WIKI_DIR

files=""
count=0

for file in *
do
  echo "processing $file"
  files="$files $file"
  count=$(($count+1))

  if [ $count -ge $NUM_FILES_TO_BATCH ]
  then
   `$LOADER $files | $DB_ENGINE $DB` 
   count=0
   files=""
   sleep $SLEEP_TIME
   if [ ! -e "$KEEP_RUN_FILE" ]
   then
    exit 0;
   fi
  fi

done

## also, load up any remaining files
`$LOADER $files | $DB_ENGINE $DB` 


