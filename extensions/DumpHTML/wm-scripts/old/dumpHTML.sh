#!/bin/bash

lang=$1
shift
dest=/var/static/$lang-new

if [ ! -d $dest ];then
	rm -rf /mnt/upload3/wikipedia/$lang/shared
	mkdir $dest
	ln -s /home/wikipedia/htdocs/wikipedia.org/images $dest/images
	ln -s /mnt/wikipedia/htdocs/wikipedia.org/upload/$lang $dest/upload
	ln -s /home/wikipedia/common/php-1.5/skins $dest/skins
	cp /var/static/COPYING.html $dest/COPYING.html
fi

cd /home/wikipedia/common/php-1.5/maintenance
#php dumpHTML.php $lang'wiki' --interlang --force-copy -d $dest "$@"
php dumpHTML.php $lang'wiki' --interlang -d $dest "$@"

