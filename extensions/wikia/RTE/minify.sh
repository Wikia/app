#!/bin/bash
# This shell script is used to concatenate and minify JS and CSS files (CK core and RTE code)
svn up

php minify.php $1
