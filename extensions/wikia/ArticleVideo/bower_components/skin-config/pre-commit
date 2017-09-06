#!/bin/sh

export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
export PATH="/usr/local/bin/ruby:/opt/local/bin:/opt/local/sbin:/usr/local/bin::/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/git/bin"

echo "validating skin config against the schema..."
node ./validate.js skin-schema.json skin.json
