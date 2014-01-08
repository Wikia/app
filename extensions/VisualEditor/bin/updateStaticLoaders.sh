#!/usr/bin/env bash
cd $(cd $(dirname $0)/..; pwd)

php maintenance/makeStaticLoader.php --target demo --write-file demos/ve/index.php
php maintenance/makeStaticLoader.php --target test --write-file modules/ve/test/index.php
