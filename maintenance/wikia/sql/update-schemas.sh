#!/bin/bash
DATABASES='archive dataware specials stats statsdb swift_sync wikicities'

for DATABASE in $DATABASES
do
	echo "Updating schema of tables in $DATABASE database ..."

	DB_PARAMS=`dbparams.pl --type slave --name $DATABASE`
	mysqldump --set-gtid-purged=OFF --no-data $DB_PARAMS | grep --invert-match --regexp='^\/\*\!' | sed 's/AUTO_INCREMENT=[0-9]* //g' > ${DATABASE}-schema.sql
done
