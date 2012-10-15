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
:: This batch will update the current working copy with the SVN HEAD.
:: It requires "svn" to be in your environment PATH.
::

CLS

:: Move to the "root" directory.
CD ../

:: Executes FCKeditor.LangTools
svn update

:: Move back to the "_dev" directory.
CD _dev

ECHO.
PAUSE
