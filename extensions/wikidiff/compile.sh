#! /bin/sh
swig -php4 -c++ wikidiff.i
g++ -O2 `php-config --includes` -shared -o php_wikidiff.so wikidiff.cpp wikidiff_wrap.cpp

