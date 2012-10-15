This extension provides an offline viewing mode for Wikipedia dumps, or
any other wiki.

Be aware that you will need a Wikipedia dump and the corresponding index,
see the project page if you need help:

    For a recent English, compressed backup of all article text (6.3Gb
    once you build an index):
http://download.wikimedia.org/enwiki/20101011/enwiki-20101011-pages-articles.xml.bz2

    For a small testing database (or if you speak Tagalog), try this
http://wikipedia-offline-patch.googlecode.com/files/wiki-splits-tl.zip

    or browse many other languages and wiki projects:
http://dumps.wikimedia.org/backup-index.html



The project page has binary distributions for macos, windows, and linux,
which include a webserver and supporting libraries.
   http://code.google.com/p/wikipedia-offline-patch

There is an unusual dependency: the Xapian indexing library and its PHP
bindings.  Also, you will have to configure some type of revision_text
caching by setting $wgRevisionCacheExpiry and $wgCacheType.


= Acknowledgements =
The current author is Adam Wight, who can be reached through the
wikipedia-offline-patch project page or at adamw on ludd.net.

Thanassis Tsiodras has a great page explaining how to build a working
offline wikipedia:
    http://users.softlab.ece.ntua.gr/~ttsiod/buildWikipediaOffline.html

Wikipedia Offline Client was the starting point for this project.
    https://projects.fslab.de/projects/wpofflineclient/

MediaWiki developers contributed valuable insight.


This software and its source code are licensed as GPL.
