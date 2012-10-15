#!/bin/bash
set -e

svn co -N http://svn.wikimedia.org/svnroot/mediawiki mw-snapshot
cd mw-snapshot
svn co -N http://svn.wikimedia.org/svnroot/mediawiki/trunk
svn co -N http://svn.wikimedia.org/svnroot/mediawiki/branches
cd branches
svn co -N http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_10
svn co -N http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_11
svn co -N http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_12
svn co http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_10/extensions REL1_10/extensions
svn co http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_11/extensions REL1_11/extensions
svn co http://svn.wikimedia.org/svnroot/mediawiki/branches/REL1_12/extensions REL1_12/extensions
cd ../trunk
svn co http://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions
