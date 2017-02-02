#! /bin/bash
set -ex

BASE_PATH=$(pwd)

composer install
composer dump-autoload
composer validate --no-interaction

if [ "$TYPE" == "coverage" ]
then
	composer phpunit -- --coverage-clover $BASE_PATH/build/coverage.clover
elif [ "$DOCTRINE" != "" ]
then
	composer require 'doctrine/cache='$DOCTRINE --prefer-source --update-with-dependencies
	composer phpunit
else
	composer phpunit
fi
