#! /bin/bash

# Requires VisualEditor.i18n.php to still contain all messages
# To reset it to that state, you can run:
# $ git reset HEAD^ VisualEditor.i18n.php
# $ git checkout VisualEditor.i18n.php
# Then to reset it back the way it was:
# $ git reset VisualEditor.i18n.php
# $ git checkout VisualEditor.i18n.php

if [ -e i18n ]
then
	cat <<END >&2
ERROR: i18n directory already exists
This script uses the i18n directory as a temporary directory
Please ensure you are in the top-level directory (VisualEditor), delete the i18n directory,
and try again
END
	exit 1
fi

mkdir i18n

echo Building author lists... >&2

for lang in $(
	grep "^\\\$messages\[" VisualEditor.i18n.php \
	| sed "s/^\\\$messages\['//" \
	| sed "s/'.*\$//"
)
do
	grep -B 100 "\\$messages['$lang']" VisualEditor.i18n.php \
		| grep '@author' \
		| sed 's/^.*@author //g' \
		> i18n/$lang.authors
done

echo Building JSON blobs... >&2

cat <<END | php -a > /dev/null 2>&1
require_once("VisualEditor.i18n.php");
foreach ( \$messages as \$lang => \$msgs ) {
	\$newArr = array(
		'@metadata' => array(
			'authors' => array_map( 'trim', file( "i18n/\$lang.authors" ) )
		)
	);
	\$newArr += \$msgs;
	file_put_contents(
		"i18n/\$lang.json",
		json_encode( \$newArr, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE )
	);
}
END

echo Splitting JSON blobs... >&2

for group in oojs-ui ve ve-mw ve-wmf
do
	mkdir -p modules/$group/i18n
	for f in i18n/*.json
	do
		(
			(
				head -n $(grep -n '},' $f | head -n 1 | cut -d : -f 1) $f
				for msg in $(cat bin/msgs-$group)
				do
					grep "\"$msg\"" $f
				done
			) | sed '${s/,$//}'
			echo -n '}'
		) > modules/$group/$f
		if grep '^    "[^@]' modules/$group/$f > /dev/null
		then
			echo modules/$group/$f >&2
		else
			rm modules/$group/$f
			echo Skipping modules/$group/$f
		fi
	done
done

rm -rf i18n

echo All done >&2
