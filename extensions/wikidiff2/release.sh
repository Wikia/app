#!/bin/bash

if [ X$1 == X ];then
	echo "Usage: release.sh <version>"
fi

sed "s/VERSION/$1/" wikidiff2.spec > /usr/src/redhat/SPECS/wikidiff2.spec
mkdir -p /usr/src/redhat/SOURCES/wikidiff2-$1
cp Makefile standalone.cpp wikidiff2.cpp wikidiff2.h wikidiff2.i wikidiff2.spec DiffEngine.h Word.h JudyHS.h /usr/src/redhat/SOURCES/wikidiff2-$1
cd /usr/src/redhat/SOURCES
tar -czf wikidiff2-$1.tar.gz wikidiff2-$1
rpmbuild -ba ../SPECS/wikidiff2.spec

