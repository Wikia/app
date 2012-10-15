@echo off
pushd %~dp0 > NUL
set THIS=%CD%
popd > NUL

start C:\perl\bin\wperl -x "%THIS%\ee.pl" %*
