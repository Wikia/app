#!/bin/bash

java -jar mwdumper.jar --format=sql:1.5 $1 | mysql5 -r -u root -p $2 wikidb
