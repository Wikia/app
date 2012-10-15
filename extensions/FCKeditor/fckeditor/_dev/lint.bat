@ECHO OFF

::
:: FCKeditor - The text editor for Internet - http://www.fckeditor.net
:: Copyright (C) 2003-2010 Frederico Caldeira Knabben
::
:: == BEGIN LICENSE ==
::
:: Licensed under the terms of any of the following licenses at your
:: choice:
::
::  - GNU General Public License Version 2 or later (the "GPL")
::    http://www.gnu.org/licenses/gpl.html
::
::  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
::    http://www.gnu.org/licenses/lgpl.html
::
::  - Mozilla Public License Version 1.1 or later (the "MPL")
::    http://www.mozilla.org/MPL/MPL-1.1.html
::
:: == END LICENSE ==
::

IF "%1"=="" GOTO NoParam

ECHO Generating %1...
bin\jsl -conf lint.conf -nofilelisting -nologo > %1

ECHO.
ECHO Process completed.
ECHO.

GOTO End

:NoParam

bin\jsl -conf lint.conf -nofilelisting -nologo

ECHO.

:End
