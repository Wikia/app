#!/bin/bash

set -e

host="$1"

dir="`dirname "$0"`"
script="$dir/getDatabase.php"

usage() {
    (
        echo "USAGE:"
        echo "  $0 host"
        echo
        echo "EXAMPLE:"
        echo "  $0 sims"
    ) 1>&2
    exit 1
}

if [ "$host" = "" ]; then
    usage
fi

url='http://'"$host"'.wikia.com/wiki/Special:Version'
echo
echo Checking db name and cluster from $url
echo
out="`curl -L "$url" | egrep -o 'cluster: c[1-9]|wgDBname="[^"]*"'`"

dbname="`echo "$out" | grep wgDBname | sed 's/.*"\([^"]*\)"/\1/'`"
cluster="`echo "$out" | grep cluster | sed 's/.*\([1-9]\).*/\1/' | tr 123456789 ABCDEFGHIJ`"

echo
echo "dbname: $dbname"
echo "cluster: $cluster"
echo
echo "About to issue php $script -d $dbname -c $cluster"
echo
echo -n "Hit enter to continue, Ctrl-C to cancel"
read

php $script -d "$dbname" -c "$cluster"
