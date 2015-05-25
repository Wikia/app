# Wikia's Makefile for executing unit tests

# command to run PHPUnit
CMD_PHPUNIT=php run-test.php \
	--log-junit=build/logs/phpunit.xml \
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
		--exclude-group Infrastructure,Integration,Broken,Stub,Monitoring,Hack

# runs integration tests only
phpunit-infrastructure: prepare
	${CMD_PHPUNIT} \
		--group Infrastructure,Integration

# runs all (i.e. both unit and integration) tests from a given directory or a file
phpunit-single: prepare
	${CMD_PHPUNIT} \
		--exclude-group Broken \
		${test}

# runs fast unit tests only
phpunit-fast: prepare
	${CMD_PHPUNIT} \
		--exclude-group Slow,Infrastructure,Integration,Broken,Stub,Monitoring,Hack,UsingDB

# lists all slow test cases with execution time
phpunit-slow-list: prepare
	${CMD_PHPUNIT} \
		--exclude-group=Infrastructure,Integration,Broken,Stub,Monitoring,Hack \
		--slow-list

# run tests for a specific group
phpunit-group: prepare
	${CMD_PHPUNIT} \
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
