#!/bin/sh
## This script dowloads, builds and installs a local binary of ploticus
## into this extension folder, with settings suitable for most UNIX servers.
##
## If ploticus is provided as a package by your distribution and you can get
## it installed, you should instead use that procedure to install ploticus.
##

mkdir -m 700 ploticus
set -e

cd ploticus
wget http://downloads.sourceforge.net/ploticus/pl241src.tar.gz?download
tar -xzf pl*src.tar.*
cd pl*src
cd src

# Using setting 1 (default), appropiate for UNIX servers: Only pl executable with no X11

# Choose GD with FreeType2

# Uncomment section 4
sed "/Option 4: use your own GD resource with FreeType2 fonts enabled/,/Option 5/ s/^#//g"  Makefile > Makefile2
# And comment section 1
sed "/Option 1: use bundled GD16/,/Option 2: use bundled GD13 (pseudoGIF only)/ s/^/#/g"  Makefile2 > Makefile

make

# Copy to the extension folder
make INSTALLBIN=../../.. install
cd ../../..
rm -r ploticus

# Make MediaWiki know where is this binary located
echo '$wgTimelineSettings->ploticusCommand = dirname( __FILE__ ) . "/pl";' >> Timeline.php

