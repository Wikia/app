#! /bin/bash

echo "Creating tables..."
mysql -e "set global foreign_key_checks=0;set global sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION';"

mysql -e "create database firefly;"
mysql firefly < ../maintenance/tables.sql

mysql firefly < ../maintenance/wikia/sql/wikicities-schema.sql

mysql firefly  < ../maintenance/wikia/sql/specials-schema.sql

mysql firefly < ../maintenance/wikia/sql/dataware-schema.sql

mysql firefly < ../maintenance/wikia/sql/portability_db-schema.sql

mysql firefly < ../maintenance/wikia/wikia_user_properties.sql

mysql -e "set global foreign_key_checks=1;"

mysql firefly < ./travis/initial-wiki.sql

echo "Configuring config..."
[[ ! -z ../../config ]] && cp -r ./travis/config ../../config || (echo "Config folder already exists 😞" && exit 1)

echo "Building localisation cache..."

export WIKIA_ENVIRONMENT=dev
export WIKIA_DATACENTER=poz

mkdir -p ../../cache

SERVER_DBNAME=firefly php ../maintenance/rebuildLocalisationCache.php --primary --threads=2 --force-wiki-id=165 >/dev/null >&/dev/null

echo "Applying patches..."

SERVER_DBNAME=firefly php ../maintenance/update.php --quick --ext-only

./php-all-tests || exit 1
