#
# FCKeditor - The text editor for Internet - http://www.fckeditor.net
# Copyright (C) 2003-2010 Frederico Caldeira Knabben
#
# == BEGIN LICENSE ==
#
# Licensed under the terms of any of the following licenses at your
# choice:
#
#  - GNU General Public License Version 2 or later (the "GPL")
#    http://www.gnu.org/licenses/gpl.html
#
#  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
#    http://www.gnu.org/licenses/lgpl.html
#
#  - Mozilla Public License Version 1.1 or later (the "MPL")
#    http://www.mozilla.org/MPL/MPL-1.1.html
#
# == END LICENSE ==
#

##
# Calls the JavaScript Lint (jsl) with the predefined configuration
# if a filename is passed as a parameter it writes there the results
# else the output is shown on the screen
#
# This file uses the Mac jsl lint and the difference in the .conf file
# is just due to the path separator in the OS
#

if [ "$1" = "" ]
then
	./bin/jsl -conf lint.mac.conf -nofilelisting -nologo
else
	echo Generating $1 ...
	./bin/jsl -conf lint.mac.conf -nofilelisting -nologo > $1
	echo
	echo Process completed.
fi
