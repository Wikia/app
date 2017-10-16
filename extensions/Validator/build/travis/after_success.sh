#! /bin/bash

set -x

originalDirectory=$(pwd)

if [ "$TYPE" == "coverage" ]
then
	wget https://scrutinizer-ci.com/ocular.phar
	du -hs $originalDirectory/build/coverage.clover
	ls -lap $originalDirectory
	ls -lap $originalDirectory/build
	php ocular.phar code-coverage:upload --format=php-clover $originalDirectory/build/coverage.clover
fi