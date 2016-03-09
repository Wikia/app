#!/bin/bash
OUTDIR=$1

mkdir $OUTDIR
php unused_files.php > $OUTDIR/unused_files.txt
php used_files.php > $OUTDIR/used_files.txt
php file_heat_map.php > $OUTDIR/file_heat_map.html
mkdir $OUTDIR/line_heat_maps
for x in `cat $OUTDIR/used_files.txt`; do echo "Starting $x"; OUTFILE=`echo $x | sed "s/\\//_/g"`; php line_heat_map.php $x > $OUTDIR/line_heat_maps/$OUTFILE.html; done
