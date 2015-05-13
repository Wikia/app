#!/bin/bash

# Script to update and deploy to gh-pages
# @author: Kenneth Kouot <kenneth@wikia-inc.com>

# Parse and save current branch
curr_git_branch=$(git symbolic-ref HEAD | sed -e 's,.*/\(.*\),\1,')
has_uncommited_changes=`git status -s`

if [ ! -z "$has_uncommited_changes" ]; then
    echo "Sorry, this update script won't run until you've taken care of those uncommitted changes. It's FOR YOUR OWN GOOD." && exit 1
fi

# Kill the Jekyll process
kill -9 `ps -ef | grep jekyll | grep -v grep | tr -s " " | cut -d " " -f3`

# Delete remote and local 'gh-pages' branches
env -i git push origin :gh-pages
env -i git branch -D gh-pages

# Branch and checkout new 'gh-pages' branch, from your current working branch
env -i git checkout -b gh-pages

# Remove contents of pwd
if [ -d "gh-pages" ]; then
    find * -maxdepth 0 -name 'node_modules' -prune -o -exec echo '{}' ';'
else 
    echo "It doesn't look like you're in the right folder, please check that you're in the root of your style-guide repo"
fi

# Copy the contents of gh-pages/ from your dev branch
env -i git checkout $curr_git_branch -- gh-pages/
# and make it's contents top level for the directory (GitHub pages requires this)
env -i cp -R gh-pages/* ./
# remove the cruft
env -i rm -rf gh-pages/

# Update the remote
env -i git add --all 
env -i git commit -m 'Updated gh-pages from dev'
env -i git push origin gh-pages

# Return to to working branch
env -i git checkout $curr_git_branch

# Reminder to restart Jekyll server
echo "Your Jekyll server process has been killed as part of this update, remember to restart to continue local development :D"
