#!/bin/bash
rm -f *php;

TEMPFILE=/tmp/ckedit-$$;

FILES=$(ls *js | grep -vP 'script|lang');
COUNT=$(echo -n $FILES | wc -w);

PROCESSED=1

for FILE in $FILES; do
	echo -ne "Processing $PROCESSED of $COUNT"\\r
	node script.js $FILE > $TEMPFILE;
	PHP=$(php -nr "dl('json.so'); var_export(json_decode(file_get_contents('$TEMPFILE')));");
	echo -ne "<?php\n$PHP" | sed -e 's/stdClass::__set_state(//g' | sed -e 's/))/)/g' > $FILE.php;
	let PROCESSED=PROCESSED+1;
done;

rm $TEMPFILE;
