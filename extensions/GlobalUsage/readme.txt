When using a shared image repository, it is impossible to see within MediaWiki
whether a file is used on one of the slave wikis. On Wikimedia this is handled
by the CheckUsage tool on the toolserver, but it is merely a hack of function 
that should be built in.

GlobalUsage creates a new table globalimagelinks, which is basically the same
as imagelinks, but includes the usage of all images on all associated wikis,
including local images. The field il_from has been replaced by gil_wiki,
gil_page, gil_page_namespace and gil_page_title which contain respectively the
interwiki prefix, page id and page namespace and title. Since the foreign wiki
may use different namespaces, the namespace name needs to be included in the 
link as well.

There should be one globalimagelinks table per farm, even if multiple shared
image repositories are used. The field gil_is_local indicates whether the file
exists locally.

== GlobalUsageDaemon and populating the table ==
This extension provides a daemon which can be used when for some reason hooks
can not be used, like on the Toolserver. This daemon will readout recentchanges
to fill the globalimagelinks table.

This daemon is also useful for populating the globalimagelinks table. Using
this method it is possible to get an as consistent as posible database. To do
so first create the table on the master wiki. Then, on each project separately:
* Run extensions/GlobalUsage/populateGlobalUsage.php on that wiki. See
  php extensions/GlobalUsage/populateGlobalUsage.php --help for information.
* When the daemon has finished populating the table from the local imagelinks
  and started to follow recentchanges, enable the extension.
* When the daemon has reached the time at which the extension was enabled, 
  the daemon can be stopped.