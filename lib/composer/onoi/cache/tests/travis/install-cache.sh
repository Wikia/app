#!/bin/bash
set -ex

BASE_PATH=$(pwd)
MW_INSTALL_PATH=$BASE_PATH/../mw

cd $MW_INSTALL_PATH

if [ "$MW" != "" ]
then
	echo -e "Running MW root composer install build on $TRAVIS_BRANCH \n"
fi

if [ "$CACHE" != "" ]
then
	composer require 'onoi/cache='$CACHE --prefer-source --update-with-dependencies
else
	composer init --stability dev
	composer require onoi/cache "dev-master" --prefer-source --dev

	cd vendor/onoi/cache

	# Pull request number, "false" if it's not a pull request
	# After the install via composer an additional get fetch is carried out to
	# update th repository to make sure that the latests code changes are
	# deployed for testing
	if [ "$TRAVIS_PULL_REQUEST" != "false" ]
	then
		git fetch origin +refs/pull/"$TRAVIS_PULL_REQUEST"/merge:
		git checkout -qf FETCH_HEAD
	else
		git fetch origin "$TRAVIS_BRANCH"
		git checkout -qf FETCH_HEAD
	fi

fi

if [ "$DOCTRINE" != "" ]
then
	cd $MW_INSTALL_PATH

	composer require 'doctrine/cache='$DOCTRINE --prefer-source --update-with-dependencies
fi

if [ "$ZENDCACHE" != "" ]
then
	cd $MW_INSTALL_PATH

	composer require 'zendframework/zend-cache='$ZENDCACHE --prefer-source --update-with-dependencies
fi
