# Wikia's Makefile for executing unit tests

# path to logs folder
LOGS_PATH=build/logs

# command to run PHPUnit
CMD_PHPUNIT=php -v && php -d xdebug.coverage_enable=0 -d opcache.enable=0 run-test.php \
	--stderr --configuration=phpunit.xml

# command to run PHPUnit Code Coverage
CMD_PHPUNIT_COVERAGE=php -v && php -d xdebug.coverage_enable=1 -d opcache.enable=0 run-test.php \
	--configuration=phpunit.xml

# command to run karma
CMD_KARMA=../node_modules/karma/bin/karma start \
	--single-run \
	--no-auto-watch

# set up an environment
export SERVER_DBNAME=firefly
unexport MW_INSTALL_PATH

all help:
	# Consult README.md file

# prepare the environment
prepare:
	rm -rf build && mkdir -p build && mkdir -p build/logs

#
# PHP TESTS
#

# runs unit tests
phpunit: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-unit.xml \
		--exclude-group Infrastructure,Integration,Broken,Stub,Monitoring,Hack,ExternalIntegration,ContractualResponsibilitiesValidation

# runs integration tests only
phpunit-infrastructure: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-infrastructure.xml \
		--group Infrastructure,Integration

# runs all (i.e. both unit and integration) tests from a given directory or a file
phpunit-single: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-single.xml \
		--exclude-group Broken \
		${test}

# runs all tests from given directory or file and produce HTML and console tests coverage result
phpunit-single-coverage: prepare
		rm -rf coverage && mkdir -p coverage
		${CMD_PHPUNIT_COVERAGE} \
				--coverage-html "coverage" \
				--coverage-text \
				--exclude-group Broken \
				--whitelist ${files} \
				${test}

# runs fast unit tests only
phpunit-fast: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-fast.xml \
		--exclude-group Infrastructure,Integration,Broken,Stub,Monitoring,Hack,UsingDB,ExternalIntegration

# run tests for a specific group
phpunit-group: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-group.xml \
		--group $(GROUP)

#
# JavaScript TESTS
#

# runs unit tests
karma-unit: prepare
	${CMD_KARMA} \
		karma/js-unit.conf.js

# runs infrastructure tests
karma-integration: prepare
	${CMD_KARMA} \
		karma/js-integration.conf.js

#
# CODE COVERAGE
#

# PHP
phpunit-coverage: prepare
	mkdir -p build/coverage

	${CMD_PHPUNIT_COVERAGE} ${test} \
		--log-junit=${LOGS_PATH}/phpunit-coverage.xml \
		--exclude-group Broken \
		--coverage-html build/coverage \
		--coverage-clover build/coverage.xml
