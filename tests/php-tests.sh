#!/bin/bash

PHP_PARAMS="-d short_open_tag=On -d variables_order=EGPCS -d display_errors=1"

mysqlparams() {
	[[ ! -z $MYSQL_USER ]] && echo "-u $MYSQL_USER -p$MYSQL_PASSWORD"
}

echo "Creating tables..."
mysql $(mysqlparams) -e "set global foreign_key_checks=0;set global sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION';"

mysql $(mysqlparams) -e "drop database if exists firefly; create database firefly default character set latin1 collate latin1_swedish_ci;"
mysql $(mysqlparams) firefly < ../maintenance/tables.sql

mysql $(mysqlparams) firefly < ../maintenance/wikia/sql/wikicities-schema.sql

mysql $(mysqlparams) firefly  < ../maintenance/wikia/sql/specials-schema.sql

mysql $(mysqlparams) firefly < ../maintenance/wikia/sql/dataware-schema.sql

mysql $(mysqlparams) firefly < ../maintenance/wikia/sql/portability_db-schema.sql

mysql $(mysqlparams) firefly < ../maintenance/wikia/wikia_user_properties.sql

mysql $(mysqlparams) -e "set global foreign_key_checks=1;"

# this fixture is needed to make localisation cache rebuild etc. work prior to starting the tests
mysql $(mysqlparams) firefly < ./travis/initial-wiki.sql

echo "Configuring config..."
[[ ! -z ../../config ]] && cp -r ./travis/config ../../ || (echo "Config folder already exists 😞" && exit 1)

echo "Building localisation cache..."

export WIKIA_ENVIRONMENT=dev
export WIKIA_DATACENTER=poz
export SERVER_DBNAME=firefly
mkdir -p ../../cache

SERVER_DBNAME=firefly php $PHP_PARAMS ../maintenance/rebuildLocalisationCache.php --primary --threads=2 --force-wiki-id=165

echo "Applying patches..."

SERVER_DBNAME=firefly php $PHP_PARAMS ../maintenance/update.php --quick --ext-only

export PHIREMOCK_HOST=127.0.0.1
export PHIREMOCK_PORT=10349

../lib/composer/bin/phiremock -i $PHIREMOCK_HOST -p $PHIREMOCK_PORT >/dev/null &
PHIREMOCK_PID=$!

rm -rf build && mkdir -p build && mkdir -p build/logs

cat travis/php_unit_tests_banner.txt && php -v && php $PHP_PARAMS -d xdebug.coverage_enable=0 -d opcache.enable=0 run-test.php \
	--stderr --configuration=phpunit.xml \
	--exclude-group Infrastructure,Integration,ExternalIntegration,ContractualResponsibilitiesValidation "$@" && cat travis/php_integration_tests_banner.txt && \
	php -v && php $PHP_PARAMS -d xdebug.coverage_enable=0 -d opcache.enable=0 run-test.php \
	--stderr --configuration=phpunit.xml \
	--group Integration "$@"

RESULT=$?

rm -rf ../../config
kill $PHIREMOCK_PID

exit $RESULT
