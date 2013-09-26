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

# Disable parallel processing which seems to be causing problems under Ruby 1.8
jsduck --config=config.json --processes=0 --color --warnings-exit-nonzero
ec=$?

rm eg-iframe.html
cd - > /dev/null

# Exit with exit code of jsduck command
exit $ec
