#!/bin/sh

#
# create thumbnail using cutycapt and imagemagick convert
#
#
# usage thumbnail.sh <url> <target.png>

TMPFILE="`tempfile`".png
URL="$1"
TARGET="$2"
#echo $TMPFILE;
echo "Getting $URL"
 /usr/bin/xvfb-run --server-args="-screen 0, 1024x768x24" /usr/bin/cutycapt --url=$URL --out=$TMPFILE --delay=5000
if [ -f $TMPFILE ];
then
	/usr/bin/convert -thumbnail "250x188^" -crop 250x188+0+0 -antialias +repage $TMPFILE $TARGET
	rm $TMPFILE
fi
