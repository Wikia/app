#!/usr/bin/env bash
cd $(cd $(dirname $0); pwd)

(
	while IFS='' read -r l
	do
		if [[ "$l" == "{{VE-LOAD-HEAD}}" ]]
		then
			php ../maintenance/makeStaticLoader.php --fixdir --section=head --ve-path=../modules/ $*
		elif [[ "$l" == "{{VE-LOAD-BODY}}" ]]
		then
			php ../maintenance/makeStaticLoader.php --fixdir --section=body --ve-path=../modules/ $*
		else
			echo "$l"
		fi
	done
) < eg-iframe.tpl | php > eg-iframe.html

# allow custom path to jsduck, or custom version (eg JSDUCK=jsduck _4.10.4_)
JSDUCK=${JSDUCK:-jsduck}

# Support jsduck 4.x and 5.x
jsduckver="$($JSDUCK --version | sed -e 's/[.].*//')"
if [  "$jsduckver" = "JSDuck 4" ]; then
	jsduckopt="--meta-tags ../.docs/MetaTags.rb"
else
	jsduckopt="--tags ../.docs/CustomTags.rb"
fi

# Disable parallel processing which seems to be causing problems under Ruby 1.8
$JSDUCK --config config.json $jsduckopt --processes 0 --color --warnings-exit-nonzero
ec=$?

rm eg-iframe.html
cd - > /dev/null

# Exit with exit code of jsduck command
exit $ec
