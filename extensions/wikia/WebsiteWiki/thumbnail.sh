#!/bin/sh

#
# create thumbnail using cutycapt and imagemagick convert
#
#
# usage thumbnail.sh <url> <target.png>

if [ $# -ne 2 ]
then
  echo "Usage: `basename $0` <url> <target.png>"
  exit 1
fi
TMPFILE="`tempfile`".png
URL="$1"
TARGET="$2"
/usr/bin/xvfb-run --server-args="-screen 0, 1024x768x24" /usr/bin/cutycapt --url=$URL --out=$TMPFILE --delay=5000
if [ -f $TMPFILE ];
then
	/usr/bin/convert -thumbnail "250x188^" -crop "250x188+0+0" +repage $TMPFILE $TARGET
	chmod ug+rw $TARGET
	rm $TMPFILE
fi
