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
:: This batch publishes the development version of FCKeditor to a directory so
:: it is ready to be packed for public release.
::

:: Update this variable for each new release.
SET RELEASER_VERSION=2.6.6

CLS

:: Look for the environment variable FCK_RELEASER_PATH.
SET RELEASER_PATH=%FCK_RELEASER_PATH%

:: If we have a command line argument, use it as the target path.
IF NOT (%1)==() SET RELEASER_PATH=%1

:: If not defined, set it to the default value.
IF (%RELEASER_PATH%)==() SET RELEASER_PATH=../../fckeditor.release/

php releaser/fckreleaser.php ../ "%RELEASER_PATH%" "%RELEASER_VERSION%"

:End

:: Delete custom variables.
SET RELEASER_VERSION=
SET RELEASER_PATH=
