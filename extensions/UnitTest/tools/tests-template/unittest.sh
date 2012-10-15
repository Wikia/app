#!/bin/sh
################################################################################
#
# Wikimedia Foundation
#
# LICENSE
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
#
# @license		http://www.gnu.org/copyleft/gpl.html GNU GENERAL PUBLIC LICENSE
# @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
#
################################################################################
#
# The script:
#
# unittest.sh - Launch PHPUnit for specific test group(s).
#
################################################################################
#
# Debugging the script
#
# The set -x option causes sh to print each command to standard error before 
# executing it. Since this can generate a lot of output, you may want to turn 
# tracing on just before the section that you want to trace, and turn it off 
# immediately afterward:
#set -x
#
################################################################################
#
# help()
#
################################################################################
help()
{
	cat <<HELP

NAME
	unittest.sh -- Run phpunit

SYNOPSIS
	$0
		[-h | --help] [help]
		[-g | --list-groups] ["relative/path/to/file"]

		[-d | --debug ]
		[-nc | --no-configuration ]

		[-cc | --coverage-clover ["/full/path/to/index.xml"] ]
		[-ch | --coverage-html ["/full/path/to/folder"] ]
		[-tdh | --testdox-html ["/full/path/to/testdox.html"] ]
		[-tdt | --testdox-text ["/full/path/to/testdox.txt"] ]

		[-ljs | --log-json ["/full/path/to/log.json"] ]
		[-lju | --log-junit ["/full/path/to/log.xml"] ]

		[-a | --all ]

DESCRIPTION
	The unittest.sh script is designed to facilitate running phpunit.
	
EXAMPLES

	# List all groups available for testing

	$0 -g

	# List all groups available for testing in the file PostTestCase

	$0 -g GlobalCollect/AllTests.php

	# List all groups available for testing in the file PostTestCase

	$0 -g GlobalCollect/PostTestCase.php

	# Run unit testing with html code coverage report to default path

	$0 -ch

	# Run unit testing with html code coverage report

	$0 -ch GlobalCollect/AllTests

	# Run unit testing with clover code coverage report to default path

	$0 -cc

	# Run unit testing with clover code coverage report

	$0 -cc GlobalCollect/AllTests

	# Generate testdox report

	$0 -tdh
	$0 --testdox-html

	# Turn on PHPUnit debugging

	$0 -d
	$0 --debug

	# Ignore the local phpunit.xml file

	$0 -nc
	$0 --no-configuration

	# Run all testing options: -cc -ch -tdh -d -ljs -lju

	$0 -a
	$0 --all

HELP
	exit 0
}
################################################################################
#
# load_configuration()
#
# Load the configuration file
#
################################################################################
load_configuration()
{
	CONFIGURATION_FILE="unittest.conf"
	
	# Load the custom configuration file if it exists
	if [ -f "${CONFIGURATION_FILE}" ]; then
		echo "Loading the configuration file (${CONFIGURATION_FILE}) in: `pwd`"
		. ${CONFIGURATION_FILE};
	else
		
		# Load the default configuration file
		CONFIGURATION_FILE="${CONFIGURATION_FILE}.dist"
	
		if [ -f "${CONFIGURATION_FILE}" ]; then
			echo "Loading the default configuration file (${CONFIGURATION_FILE}.dist) in: `pwd`"
			. ${CONFIGURATION_FILE};
		else
			echo "The default configuration file (${CONFIGURATION_FILE}) is missing from: `pwd`"
			exit 1;
		fi
	fi
}
################################################################################
#
# Begin execution of script
#
################################################################################
# Run help if needed.
[ -z "${1}" ] && help
[ "${1}" = "-h" ] && help
[ "${1}" = "help" ] && help

#
# @var string $UNITTEST_DIRECTORY	This is the relative path to the 
# configuration file.
UNITTEST_DIRECTORY="`dirname $0`/"

# Change to script directory to keep path variables consistent.
cd ${UNITTEST_DIRECTORY}

load_configuration
################################################################################
#
# @var string $PHPUNIT_COVERAGE_HTML_LINK	The link to html code coverage
#
PHPUNIT_COVERAGE_HTML_LINK=${UNITTEST_URL}
#
# @var string $PHPUNIT_COVERAGE_CLOVER_LINK The link to clover code coverage
#
PHPUNIT_COVERAGE_CLOVER_LINK=${UNITTEST_URL}
#
# @var string $PHPUNIT_COVERAGE_TESTDOX_LINK	The link to testdox code coverage
#
PHPUNIT_COVERAGE_TESTDOX_LINK=${UNITTEST_URL}
#
# @var string $PHPUNIT_LOG_JSON_LINK	The link to json log results
#
PHPUNIT_LOG_JSON_LINK=${UNITTEST_URL}
#
# @var string $PHPUNIT_LOG_JUNIT_LINK	The link to junit log results
#
PHPUNIT_LOG_JUNIT_LINK=${UNITTEST_URL}
#
# @var string $PHPUNIT_LOG_TAP_LINK	The link to tap log results
#
PHPUNIT_LOG_TAP_LINK=${UNITTEST_URL}

# The flags that will be passed to phpunit.
#
# @var string $PHPUNIT_UNITTEST_FLAGS
#
PHPUNIT_UNITTEST_FLAGS=${1};

# Run unit tests without the configuration
#
# @var integer $PHPUNIT_UNITTEST_WITHOUT_CONFIGURATION	This will be equal to one if 
# phpunit.xml is not used. See the flag: -nc
#
PHPUNIT_UNITTEST_WITHOUT_CONFIGURATION=0;

# These are the flags that will be run if -a | --all is specified
#
# @var integer $PHPUNIT_UNITTEST_ALL_FLAGS
#
PHPUNIT_UNITTEST_ALL_FLAGS="-cc -ch -tdh -d -ljs -lju";
################################################################################

################################################################################
#
# Loop through options to pass to phpunit.php
#
################################################################################

#echo "Pre: ${PHPUNIT_UNITTEST_FLAGS}"

# Check to see if all options will be ran.
if [[ "${PHPUNIT_UNITTEST_FLAGS}" == "-a" ]]; then
	echo "Running all options for testing: ${PHPUNIT_UNITTEST_ALL_FLAGS}"
	PHPUNIT_UNITTEST_FLAGS=${PHPUNIT_UNITTEST_ALL_FLAGS};
fi

#echo "Post: ${PHPUNIT_UNITTEST_FLAGS}"

PHPUNIT_SKIP_FLAG=0;

for PHPUNIT_UNITTEST_FLAG in ${PHPUNIT_UNITTEST_FLAGS}
do
	if [[ "${PHPUNIT_SKIP_FLAG}" > 0 ]]; then
		#echo "PHPUNIT_SKIP_FLAG: ${PHPUNIT_SKIP_FLAG}";
		PHPUNIT_SKIP_FLAG=(${PHPUNIT_SKIP_FLAG} - 1);
		continue;
	fi

	#echo "Loop: ${PHPUNIT_UNITTEST_FLAGS}"

	case "${PHPUNIT_UNITTEST_FLAG}" in 
		
		# list-groups
		 -g|--list-groups)
			PHPUNIT_LIST_GROUPS="--list-groups" 
			break ;;
		
		# coverage-html
		-ch)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-html ${PHPUNIT_COVERAGE_HTML}";
			PHPUNIT_COVERAGE_HTML_LINK="${PHPUNIT_COVERAGE_HTML_LINK}${PHPUNIT_COVERAGE_HTML}";
			PHPUNIT_UNITTEST_WITHOUT_CONFIGURATION=1;
			continue ;;
		
		--coverage-html)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-html $2";
			PHPUNIT_COVERAGE_HTML_LINK="${PHPUNIT_COVERAGE_HTML_LINK}$2";
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		# coverage-clover
		-cc)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-clover ${PHPUNIT_COVERAGE_CLOVER}";
			PHPUNIT_COVERAGE_CLOVER_LINK="${PHPUNIT_COVERAGE_CLOVER_LINK}${PHPUNIT_COVERAGE_CLOVER}";
			continue ;;
		
		--coverage-clover)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-clover $2";
			PHPUNIT_COVERAGE_CLOVER_LINK="${PHPUNIT_COVERAGE_CLOVER_LINK}$2";
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		# no-configuration
		-nc|--no-configuration)
			PHPUNIT_OPTS="${PHPUNIT_OPTS} --no-configuration";
			continue ;;
		
		# testdox-html
		-tdh)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --testdox-html ${PHPUNIT_TESTDOX_HTML}";
			PHPUNIT_COVERAGE_TESTDOX_LINK="${PHPUNIT_COVERAGE_TESTDOX_LINK}${PHPUNIT_TESTDOX_HTML}";
			continue ;;
		
		--testdox-html)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --testdox-html $2";
			PHPUNIT_COVERAGE_TESTDOX_LINK="${PHPUNIT_COVERAGE_TESTDOX_LINK}$2";
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		# log-json
		-ljs)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --log-json ${PHPUNIT_LOG_JSON}";
			PHPUNIT_LOG_JSON_LINK="${PHPUNIT_LOG_JSON_LINK}${PHPUNIT_LOG_JSON}";
			PHPUNIT_UNITTEST_WITHOUT_CONFIGURATION=1;
			continue ;;
		
		--log-json)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --log-json $2";
			PHPUNIT_LOG_JSON_LINK="${PHPUNIT_LOG_JSON_LINK}$2";
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		# log-junit
		-lju)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --log-junit ${PHPUNIT_LOG_JUNIT}";
			PHPUNIT_LOG_JUNIT_LINK="${PHPUNIT_LOG_JUNIT_LINK}${PHPUNIT_LOG_JUNIT}";
			PHPUNIT_UNITTEST_WITHOUT_CONFIGURATION=1;
			continue ;;
		
		--log-junit)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --log-junit $2";
			PHPUNIT_LOG_JUNIT_LINK="${PHPUNIT_LOG_JUNIT_LINK}$2";
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		# debug
		-d|--debug)
			PHPUNIT_OPTS="${PHPUNIT_OPTS} --debug";
			continue ;;
		
		# file
		-f|--file)
			PHPUNIT_FILE="$2" 
			PHPUNIT_SKIP_FLAG=1;
			continue ;;
		
		*)
			PHPUNIT_GROUPS="${PHPUNIT_GROUPS:+"$PHPUNIT_GROUPS,"}${PHPUNIT_UNITTEST_FLAGS}";
			echo "-----------"
			continue ;;
	esac
done
################################################################################
#
# Information statements
#
################################################################################
echo ""

echo "SCRIPT PATH: ${PATH}"

echo ""

echo "PWD: `pwd`"

echo ""

COMMAND_OPTIONS="${PHPUNIT_OPTS} ${PHPUNIT_LIST_GROUPS} ${PHPUNIT_COVERAGE} ${PHPUNIT_GROUPS:+--group $PHPUNIT_GROUPS} ${PHPUNIT_FILE}"
echo "COMMAND: ${PHPUNIT} ${COMMAND_OPTIONS}"

echo ""

echo "HTML code coverage link: ${PHPUNIT_COVERAGE_HTML_LINK}"

echo ""

echo "Clover code coverage link: ${PHPUNIT_COVERAGE_CLOVER_LINK}"

echo ""

echo "Testdox code coverage link: ${PHPUNIT_COVERAGE_TESTDOX_LINK}"

echo ""

echo "Log results json: ${PHPUNIT_LOG_JSON_LINK}"

echo ""

echo "Log results junit: ${PHPUNIT_LOG_JUNIT_LINK}"

echo ""

################################################################################
# Debugging
#
# The set -n option causes sh to read the script but not execute any commands.
# This is useful for checking syntax.
#set -n
################################################################################

${PHPUNIT} ${PHPUNIT_OPTS} ${COMMAND_OPTIONS}
