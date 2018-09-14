#!/bin/bash

set -ex

# lint changed files compared to pull request target if PR build, else compare vs previous commit
if [ "$TRAVIS_PULL_REQUEST" == "" -o "$TRAVIS_PULL_REQUEST" == "false" ]; then
	LINT_BASE="HEAD~1"
else
	LINT_BASE="$TRAVIS_BRANCH"
fi

git diff ${LINT_BASE}..HEAD --name-only | xargs --no-run-if-empty -t composer run lint
