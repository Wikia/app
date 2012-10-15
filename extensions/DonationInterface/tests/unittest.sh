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
# @category		UnitTesting
# @package		Fundraising_Miscellaneous
# @license		http://www.gnu.org/copyleft/gpl.html GNU GENERAL PUBLIC LICENSE
# @since		r462
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
		[-l | --list-groups] ["relative/path/to/file"]

		[-d | --debug ]
		[-nc | --no-configuration ]

		[-cc | --coverage-clover ["/full/path/to/index.xml"] ]
		[-ch | --coverage-html ["/full/path/to/folder"] ]
		[-tdh | --testdox-html ["/full/path/to/testdox.html"] ]

DESCRIPTION
	The unittest.sh script is designed to facilitate running phpunit.
	
EXAMPLES

	# List all groups available for testing

	$0 -l

	# List all groups available for testing in the file PostTestCase

	$0 -l GlobalCollect/AllTests.php

	# List all groups available for testing in the file PostTestCase

	$0 -l GlobalCollect/PostTestCase.php

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
		source ${CONFIGURATION_FILE};
	else
		
		# Load the default configuration file
		CONFIGURATION_FILE="${CONFIGURATION_FILE}.dist"
	
		if [ -f "${CONFIGURATION_FILE}" ]; then
			source ${CONFIGURATION_FILE};
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
################################################################################

################################################################################
#
# Loop through options to pass to phpunit.php
#
################################################################################
while [ -n "$1" ] ; do

	case "$1" in 
		
		# list-groups
		 -l|--list-groups)
			PHPUNIT_LIST_GROUPS="--list-groups" 
			break ;;
		
		# coverage-html
		-ch)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-html ${PHPUNIT_COVERAGE_HTML}" 
			PHPUNIT_COVERAGE_HTML_LINK="${PHPUNIT_COVERAGE_HTML_LINK}${PHPUNIT_COVERAGE_HTML}" 
			shift 1 ;;
		
		--coverage-html)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-html $2" 
			PHPUNIT_COVERAGE_HTML_LINK="${PHPUNIT_COVERAGE_HTML_LINK}$2" 
			shift  ;;
		
		# coverage-clover
		-cc)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-clover ${PHPUNIT_COVERAGE_CLOVER}" 
			PHPUNIT_COVERAGE_CLOVER_LINK="${PHPUNIT_COVERAGE_CLOVER_LINK}${PHPUNIT_COVERAGE_CLOVER}" 
			shift 1 ;;
		
		--coverage-clover)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --coverage-clover $2" 
			PHPUNIT_COVERAGE_CLOVER_LINK="${PHPUNIT_COVERAGE_CLOVER_LINK}$2" 
			shift 2 ;;
		
		# no-configuration
		-nc|--no-configuration)
			PHPUNIT_OPTS="${PHPUNIT_OPTS} --no-configuration" 
			shift ;;
		
		# testdox-html
		-tdh)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --testdox-html ${PHPUNIT_TESTDOX_HTML}" 
			PHPUNIT_COVERAGE_TESTDOX_LINK="${PHPUNIT_COVERAGE_TESTDOX_LINK}${PHPUNIT_TESTDOX_HTML}" 
			shift 1 ;;
		
		--testdox-html)
			PHPUNIT_COVERAGE="${PHPUNIT_COVERAGE} --testdox-html $2" 
			PHPUNIT_COVERAGE_TESTDOX_LINK="${PHPUNIT_COVERAGE_TESTDOX_LINK}$2" 
			shift 2 ;;
		
		# debug
		-d|--debug)
			PHPUNIT_OPTS="${PHPUNIT_OPTS} --debug" 
			shift ;;
		
		# file
		-f|--file)
			PHPUNIT_FILE="$2" 
			shift 2 ;;
		
		# All groups
			ALL|all|MAX|max)
			PHPUNIT_GROUPS="" 
			break ;;
		
		*)
			PHPUNIT_GROUPS="${PHPUNIT_GROUPS:+"$PHPUNIT_GROUPS,"}$1" 
			shift ;;
	esac
done
################################################################################
#
# Information statements
#
################################################################################
echo ""

echo "SCRIPT PATH:\n\n${PATH}"

echo ""

echo "PWD:\n\n`pwd`"

echo ""

COMMAND_OPTIONS="${PHPUNIT_OPTS} ${PHPUNIT_LIST_GROUPS} ${PHPUNIT_COVERAGE} ${PHPUNIT_GROUPS:+--group $PHPUNIT_GROUPS} ${PHPUNIT_FILE}"
echo "COMMAND:\n\n${PHPUNIT} ${COMMAND_OPTIONS}"

echo ""

echo "HTML code coverage link:\n\n${PHPUNIT_COVERAGE_HTML_LINK}"

echo ""

echo "Clover code coverage link:\n\n${PHPUNIT_COVERAGE_CLOVER_LINK}"

echo ""

echo "Testdox code coverage link:\n\n${PHPUNIT_COVERAGE_TESTDOX_LINK}"

echo ""

################################################################################
# Debugging
#
# The set -n option causes sh to read the script but not execute any commands.
# This is useful for checking syntax.
#set -n
################################################################################

${PHPUNIT} ${PHPUNIT_OPTS} ${COMMAND_OPTIONS}
