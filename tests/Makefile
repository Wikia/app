# Wikia's Makefile for executing unit tests

# path to logs folder
LOGS_PATH=build/logs

# command to run PHPUnit
CMD_PHPUNIT=php -d xdebug.coverage_enable=0 run-test.php \
	--configuration=phpunit.xml

# command to run karma
CMD_KARMA=../node_modules/karma/bin/karma start \
	--single-run \
	--no-auto-watch \
	--reporters progress,junit,coverage

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

# runs external partners api integration tests only
phpunit-externals: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-externals.xml \
		--group ExternalIntegration

# runs tests for externally used parts
phpunit-contractual-responsibilities: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-contractual-responsibilities.xml \
		--group ContractualResponsibilitiesValidation

# runs all (i.e. both unit and integration) tests from a given directory or a file
phpunit-single: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-single.xml \
		--exclude-group Broken \
		${test}

# runs all tests from given directory or file and produce HTML and console tests coverage result
phpunit-single-coverage: prepare
		rm -rf coverage && mkdir -p coverage
		${CMD_PHPUNIT} \
				--coverage-html "coverage" \
				--coverage-text \
				--exclude-group Broken \
				${test}

# runs fast unit tests only
phpunit-fast: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-fast.xml \
		--exclude-group Slow,Infrastructure,Integration,Broken,Stub,Monitoring,Hack,UsingDB,ExternalIntegration

# lists all slow test cases with execution time
phpunit-slow-list: prepare
	${CMD_PHPUNIT} \
		--log-junit=${LOGS_PATH}/phpunit-slow.xml \
		--exclude-group=Infrastructure,Integration,Broken,Stub,Monitoring,Hack \
		--slow-list

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

	${CMD_PHPUNIT} ${test} \
		--log-junit=${LOGS_PATH}/phpunit-coverage.xml \
		--exclude-group Broken \
		--coverage-html build/coverage \
		--coverage-clover build/coverage.xml

#
# CODE LINTING
#
codelint-js:
	php ../maintenance/wikia/codelint.php \
		--mode=js \
		--dir=../skins/oasis,../skins/wikia,../resources/wikia,../extensions/wikia \
		--blacklist=/CodeLint/examples/anticode.js,/resources/wikia/libraries/ghostwriter/,/libraries/zepto/,/libraries/yui,/CodeLint/js/,/RTE/ckeditor/_../,/jquery/jquery-,/resources/jquery,/resources/mediawiki,/Chat/js/lib/,lib/socket.io,/AdEngine/bezen/,/extensions/wikia/hacks,/extensions/wikia/SemanticBundle,qunit/qunit.js,jasmine/jasmine.js,/resources/mediawiki.language/,/tests/ \
		--format=html \
		--output=build/jslint.html
