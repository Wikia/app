#! /bin/bash
set -ex

BASE_PATH=$(pwd)
MW_INSTALL_PATH=$BASE_PATH/../mw

cd $MW_INSTALL_PATH/vendor/onoi/cache

if [ "$TYPE" == "coverage" ]
then
	if [ "$MW" != "" ]
	then
		php ../../../tests/phpunit/phpunit.php -c phpunit.xml.dist --coverage-clover $BASE_PATH/build/coverage.clover
	else
		composer phpunit -- --coverage-clover $BASE_PATH/build/coverage.clover
	fi
else
	composer phpunit 
fi
