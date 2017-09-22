#!/bin/sh

# Check if we are currently in a submodule
if [[ -d '.git' ]]; then
  gitDir='.git'
elif [[ -f '.git' ]]; then
  gitDir=`cat .git | grep "^gitdir:" | cut -b 8-`
else
  echo "not inside a valid git repo."
  exit 1
fi

echo "adding pre-commit git hook to $gitDir"

cp -rf pre-commit $gitDir/hooks

echo "success"
exit 0
