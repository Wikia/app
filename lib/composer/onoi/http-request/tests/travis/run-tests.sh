#! /bin/bash
set -ex

BASE_PATH=$(pwd)

if [ "$TYPE" == "coverage" ]
then
	composer install
	composer validate --no-interaction
	composer phpunit -- --coverage-clover $BASE_PATH/build/coverage.clover
else
	composer install
	composer validate --no-interaction
	composer phpunit
fi
