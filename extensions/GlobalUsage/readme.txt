When using a shared image repository, it is impossible to see within MediaWiki
whether a file is used on one of the slave wikis. On Wikimedia this is handled
by the CheckUsage tool on the toolserver, but it is merely a hack of function 
that should be built in.

GlobalUsage creates a new table globalimagelinks, which is basically the same
as imagelinks, but includes the usage of all images on all associated wikis. 

The field il_from has been replaced by (gil_wiki, gil_page, gil_page_namespace, 
gil_page_title) which contain respectively the wiki id, page id and page 
namespace name (because they can not be fetched by the shared repo) and title. 

The table globalimagelinks actually does not track the usage of links of images
on the shared repository, but simply all images that do not exist on the local
wiki.

