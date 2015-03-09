#!/usr/bin/env bash
set -e

REPO_DIR=$(cd $(dirname $0)/..; pwd)

# Disable parallel processing which seems to be causing problems under Ruby 1.8
jsduck --config $REPO_DIR/.docs/config.json --processes 0

ln -s ../lib $REPO_DIR/docs/lib
