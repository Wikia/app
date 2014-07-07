#!/usr/bin/env bash
cd $(cd $(dirname $0)/..; pwd)

# allow custom path to jsduck, or custom version (eg JSDUCK=jsduck _4.10.4_)
JSDUCK=${JSDUCK:-jsduck}

# Support jsduck 4.x and 5.x
jsduckver="$($JSDUCK --version | sed -e 's/[.].*//')"
if [  "$jsduckver" = "JSDuck 4" ]; then
	jsduckopt="--meta-tags .docs/MetaTags.rb"
else
	jsduckopt="--tags .docs/CustomTags.rb"
fi

# Disable parallel processing which seems to be causing problems under Ruby 1.8
$JSDUCK --config .docs/config.json $jsduckopt --processes 0 --color --warnings-exit-nonzero
ec=$?

cd - > /dev/null

# Exit with exit code of jsduck command
exit $ec
