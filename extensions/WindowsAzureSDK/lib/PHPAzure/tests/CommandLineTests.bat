@echo off
cls
echo Running command-line tests...
echo.

REM ### Set environment variables
SET Certificate=Microsoft\WindowsAzure\Management\_files\management.pem

REM ########################################################################
REM # Storage
REM ########################################################################

REM ### Storage - ListAccounts
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php ListAccounts --ConfigFile="CommandLineTests.ini"

REM ### Storage - GetProperties
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php GetProperties --ConfigFile="CommandLineTests.ini" --AccountName="phptestsdk"

REM ### Storage - GetProperty
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php GetProperty --ConfigFile="CommandLineTests.ini" --AccountName="phptestsdk" --Property=Url

REM ### Storage - GetKeys
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php GetKeys --ConfigFile="CommandLineTests.ini" --AccountName="phptestsdk"

REM ### Storage - GetKey
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php GetKey --ConfigFile="CommandLineTests.ini" --AccountName="phptestsdk" -k=secondary

REM ### Storage - RegenerateKeys
php ..\library\Microsoft\WindowsAzure\CommandLine\Storage.php RegenerateKeys --ConfigFile="CommandLineTests.ini" --AccountName="phptestsdk" -k=secondary


REM ########################################################################
REM # Certificate
REM ########################################################################

REM ### Certificate - Add
php ..\library\Microsoft\WindowsAzure\CommandLine\Certificate.php Add --ConfigFile="CommandLineTests.ini" -sn="phptestsdk" --CertificateLocation="Microsoft\WindowsAzure\Management\_files\management.pfx" --CertificatePassword="phpazure"

REM ### Certificate - List
php ..\library\Microsoft\WindowsAzure\CommandLine\Certificate.php List --ConfigFile="CommandLineTests.ini" -sn="phptestsdk"

REM ### Certificate - Get
php ..\library\Microsoft\WindowsAzure\CommandLine\Certificate.php Get --ConfigFile="CommandLineTests.ini" -sn="phptestsdk" --CertificateThumbprint="EC91707EB5A3458386C785AFED7279392A9DDE81" --CertificateAlgorithm="sha1"

REM ### Certificate - GetProperty
php ..\library\Microsoft\WindowsAzure\CommandLine\Certificate.php GetProperty --ConfigFile="CommandLineTests.ini" -sn="phptestsdk" --CertificateThumbprint="EC91707EB5A3458386C785AFED7279392A9DDE81" --CertificateAlgorithm="sha1" --Property=Data

REM ### Certificate - Delete
php ..\library\Microsoft\WindowsAzure\CommandLine\Certificate.php Delete --ConfigFile="CommandLineTests.ini" -sn="phptestsdk" --CertificateThumbprint="EC91707EB5A3458386C785AFED7279392A9DDE81" --CertificateAlgorithm="sha1"


REM ########################################################################
REM # Hosted service
REM ########################################################################

REM ### Hosted service- List
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php List --ConfigFile="CommandLineTests.ini"

REM ### Hosted service- GetProperties
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php GetProperties --ConfigFile="CommandLineTests.ini" --Name="phptestsdk"

REM ### Hosted service - GetProperty
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php GetProperty --ConfigFile="CommandLineTests.ini" --Name="phptestsdk" --Property=Url

REM ### Hosted service - Create
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php Create --ConfigFile="CommandLineTests.ini" --Name="phptestsdk2" --Label="phptestsdk2" --Location="West Europe"

REM ### Hosted service - Update
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php Update --ConfigFile="CommandLineTests.ini" --Name="phptestsdk2" --Label="xyz" --Description="Test"

REM ### Hosted service - Delete
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php Delete --ConfigFile="CommandLineTests.ini" --Name="phptestsdk2"


REM ########################################################################
REM # Create and host service
REM ########################################################################

REM ### Create
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php Create --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --Label="commandlinetests" --Location="West Europe" --WaitFor

REM ### Deploy (staging)
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php CreateFromLocal --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --DeploymentName="testdeploy" --Label="testdeploy" --BySlot="staging" --StartImmediately --WaitFor

REM ### Info
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php GetProperties --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --ByName="testdeploy"

REM ### Swap
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php Swap --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --WaitFor

REM ### Scale out
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php EditInstanceNumber --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --ByName="testdeploy" --RoleName="PhpOnAzure.Web" --NewInstanceNumber=2

pause

REM ### Update status
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php UpdateStatus --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --ByName="testdeploy" --Status="suspended" --WaitFor

REM ### Delete
php ..\library\Microsoft\WindowsAzure\CommandLine\Deployment.php Delete --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --ByName="testdeploy" --WaitFor

REM ### Create
php ..\library\Microsoft\WindowsAzure\CommandLine\Service.php Delete --ConfigFile="CommandLineTests.ini" --Name="commandlinetests" --WaitFor


echo.
echo Finished test run.
pause