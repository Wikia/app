#! /bin/bash

# Compresses all PNGs in the current directory and puts the compressed
# version in the parent directory
#
# Requires pngcrush

for f in *.png
do
	pngcrush $f ../$f
done

