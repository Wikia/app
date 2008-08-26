#!/bin/sh

#svn revert *.php
for a in *.php; do small/autoreplace.sh $a; done;
cp done/* .

