# Wikia's Makefile for executing unit tests

# command to run PHPUnit
CMD_PHPUNIT=php run-test.php \
	--log-junit build/logs/phpunit.xml \
	--configuration phpunit.xml

# set up an environment
export SERVER_DBNAME=firefly

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
		--exclude-group Infrastructure,Integration,Broken,Stub,Monitoring,Hack \
		--slow-list

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
