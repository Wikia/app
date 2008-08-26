#! /bin/sh
swig -php4 -c++ wikidiff2.i
g++ -O2 `php-config --includes` -shared -o php_wikidiff2.so wikidiff2.cpp wikidiff2_wrap.cpp

