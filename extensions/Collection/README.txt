====================================
*Collection* Extension for MediaWiki
====================================

About the *Collection* Extension
================================

The *Collection* extension for MediaWiki_ allows users to collect articles and
generate downloadable version in different formats (PDF, OpenDocument Text etc.)
for article collections and single articles.

The extension has been developed for and tested with MediaWiki_ version 1.14
and later. Some features may not be avaialable with older MediaWikis that
don't have the `MediaWiki API`_ enabled.

The extension is being developed under the GNU General Public License by
`PediaPress GmbH`_ in close collaboration with `Wikimedia Foundation`_
and the `Commonwealth of Learning`_.

Copyright (C) 2008-2009, PediaPress GmbH

Prerequisites
=============

Install PHP with cURL support
-----------------------------

Currently Collection extension needs PHP with cURL support,
see http://php.net/curl

Install and Setup a Render Server
---------------------------------

Rendering and ZIP file generation is done by a server, which can run separately
from the MediaWiki installation and can be shared by different MediaWikis.
See the ``mw-serve`` command or the ``mwlib.cgi`` script in the mwlib_
distribution.

If you use a a render server the `MediaWiki API`_ must be enabled
(i.e. just don't override the default value of ``true`` for ``$wgEnableApi``
in your ``LocalSettings.php``).

If you have a low-traffic MediaWiki you can use the public render server running
at http://tools.pediapress.com/mw-serve/. In this case, just keep
the configuration variable $wgCollectionMWServeURL (see below) at its default
value.


Installation and Configuration of the Collection Extension
==========================================================

* Checkout the *Collection* extension from the Subversion repository into the
  ``extensions`` directory of your *MediaWiki* installation::

    cd extensions/
    svn co http://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/Collection

* Put this line in your ``LocalSettings.php``::

    require_once("$IP/extensions/Collection/Collection.php");

  and set the following global variables accordingly:

  *$wgCollectionMWServeURL (string)*
   Set this to the URL of a render server (see above).

   The default is ``"http://tools.pediapress.com/mw-serve/"``,
   a public render server for low-traffic MediaWikis hosted by PediaPress.

   Note that the MediaWiki must be accessible from the render server, i.e. if
   your MediaWiki is behind a firewall you cannot use the public render server.

  *$wgCollectionMWServeCert (string)*
   Filename of a SSL certificate in PEM format for the mw-serve render server.
   This needs to be used for self-signed certificates, otherwise cURL will
   throw an error. The default is null, i.e. no certificate.

  *$wgCollectionMWServeCredentials (string)*
   Set this to a string of the form "USERNAME:PASSWORD" (or
   "USERNAME:PASSWORD:DOMAIN" if you're using LDAP), if the MediaWiki
   requires to be logged in to view articles.
   The render server will then login with these credentials using MediaWiki API
   before doing other requests.

   SECURITY NOTICE: If the MediaWiki and the render server communicate over an
   insecure channel (for example on an unencrypted channel over the internet), please
   DO NOT USE THIS SETTING, as the credentials will be exposed to eavesdropping!

  *$wgCollectionFormats*
   An array mapping names of mwlib_ writers to the name of the produced format.
   The default value is::

       array(
           'rl' => 'PDF',
       )

   i.e. only PDF enabled. If you want to add OpenDocument Text in addition to
   PDF you can set $wgCollectionFormats to something like this::

       $wgCollectionFormats = array(
           'rl' => 'PDF',
           'odf' => 'ODT',
       );

   On the public render server tools.pediapress.com, currently the following
   writers are available:

   * docbook: DocBook XML
   * odf: OpenDocument Text
   * rl: PDF
   * xhtml: XHTML 1.0 Transitional

   If you're using your own render server, the list of available writers can be
   listed with the following mwlib_ command::

     $ mw-render --list-writers

	*$wgCollectionContentTypeToFilename (array)*
	 An array matching content types to filenames for downloaded documents. The
	 default is:

		$wgCollectionContentTypeToFilename = array(
			'application/pdf' => 'collection.pdf',
			'application/vnd.oasis.opendocument.text' => 'collection.odt',
		);

	*$wgCollectionPortletFormats (array)*
	 An array containing formats (keys in $wgCollectionFormats) that shall be
	 displayed as "Download as XYZ" links in the "Print/export" portlet.
	 The default value is::

	     array( 'rl' );

	 i.e. there's one link "Download as PDF".

	*$wgCollectionHierarchyDelimiter (string or null)*
	 If not null, treat wiki pages whose title contains the configured delimiter
	 as subpages.

         For example, to treat article [[Foo/Bar]] as subpage of article [[Foo]]
	 set this variable to "/". This makes sense e.g. on wikibooks.org, but it's
	 questionable on wikipedia.org (cf. [[AC/DC]]).

	 The (only) effect is that the display title for subpages in collections
         is set to the title of the (deepest) subpage. For example, the title of
         article [[Foo/Bar]] will be displayed/rendered as "Bar".

	 The defaul value is null, which means that no hierarchy is assumed.

  *$wgCollectionArticleNamespaces (array)*
   List of namespace numbers for pages which can be added to a collection.
   Category pages (NS_CATEGORY) are always an exception (all articles in a
   category are added, not the category page itself). Default is::

    array(
      NS_MAIN,
      NS_TALK,
      NS_USER,
      NS_USER_TALK,
      NS_PROJECT,
      NS_PROJECT_TALK,
      NS_MEDIAWIKI,
      NS_MEDIAWIKI_TALK,
      100,
      101,
      102,
      103,
      104,
      105,
      106,
      107,
      108,
      109,
      110,
      111,
    );

  *$wgCommunityCollectionNamespace (integer)*
   Namespace for "community collections", i.e. the namespace where non-personal
   article collection pages are saved.

	 Note: This configuration setting is only used if the system message
	 Coll-community_book_prefix has not been set (see below).

   Default is ``NS_PROJECT``.

  *$wgCollectionMaxArticles (integer)*
   Maximum number of articles allowed in a collection.

   Default is 500.

  *$wgCollectionLicenseName (string or null)*
   License name for articles in this MediaWiki.
   If set to ``null`` the localized version of the word "License" is used.

   Default is null.

  *$wgCollectionLicenseURL (string or null)*
   HTTP URL of an article containing the full license text in wikitext format
   for articles in this MediaWiki. E.g.

       $wgCollectionLicenseURL = 'http://en.wikipedia.org/w/index.php?title=Wikipedia:Text_of_the_GNU_Free_Documentation_License&action=raw';

   for the GFDL.
   If set to null, the standard MediaWiki variables $wgRightsPage,
   $wgRightsUrl and $wgRightsText are used for license information.

   If your MediaWiki contains articles with different licenses, make sure
   that each article contains the name of the license and set $wgCollectionLicenseURL
   to an article that contains all needed licenses.

* If you want to let users save their collections as wiki pages, make sure
  $wgEnableWriteAPI is set to true, i.e. put this line in your LocalSettings.php::

    $wgEnableWriteAPI = true;

  (This is the default.)

  There are two MediaWiki rights that are checked, before users are allowed
  to save collections: To be able to save collection pages under the User
  namespace, users must have the right 'collectionsaveasuserpage'; to be able
  to save collection pages under the community namespace
  (see $wgCommunityCollectionNamespace), users must have the right
  'collectionsaveascommunitypage'. For example, if all logged-in users shall
  be allowed to save collection pages under the User namespace, but only
  autoconfirmed users, shall be allowed to save collection pages under the
  community namespace, add this to your LocalSettings.php::

    $wgGroupPermissions['user']['collectionsaveasuserpage'] = true;
    $wgGroupPermissions['autoconfirmed']['collectionsaveascommunitypage'] = true;

* As the current collection of articles is stored in the session, the session
  timeout should be set to some sensible value (at least a few hours, maybe
  one day). Adjust session.cookie_lifetime and session.gc_maxlifetime in your
  ``php.ini`` accordingly.

* Add a help page (for example ``Help:Books`` for wikis in English language).
  A repository of help pages in different languages can be found on
  `Meta-Wiki`_.

	The name of the help page is stored in the system message Coll-helppage and
	can be adjusted by editing the wiki page [[MediaWiki:Coll-helppage]].

* Add a template [[Template:saved_book]] which is transcluded on top of saved
	collection pages. An example for such a template can be found on the English
	Wikipedia: http://en.wikipedia.org/wiki/Template:Saved_book

	The name of the template can be adjusted via the system message
	Coll-savedbook_template, i.e. by editing [[MediaWiki:Coll-savedbook_template]].

* To enable ZENO and Okawix export, uncomment the corresponding lines in $wgCollectionFormats
  (file Collection.php). These exports are devoted to the Wikimedia projects and their mirrors.
  They cannot be used on other wikis since they get data and search engine indexes from the cache
  of wikiwix.com.

Customization via System Messages
=================================

There are several system messages, which can be adjusted for a MediaWiki
installation. They can be changed by editing the wiki page
[[MediaWiki:SYSTEMMESSAGENAME]], where SYSTEMMESSAGENAME is the name of the
system message.

* Coll-helppage: The name of the help page (see above).
  The default for English language is "Help:Books", and there exist translations
	for lots of different languages.

* Coll-user_book_prefix: Prefix for titles of "user books" (i.e. books for
  personal use, as opposed to "community books"). If the system message is empty
	or '-' (the default), the title of user book pages is constructed
	as User:USERNAME/Books/BOOKTITLE. If the system message is set and its content
	is PREFIX, the title of user book pages is constructed by directly concatenating
	PREFIX and the BOOKTITLE, i.e. there's no implicitly inserted '/' inbetween!

* Coll-community_book_prefix: Prefix for titles of "community books" (cf. "user
  books" above). If the system message is empty or '-' (the default), the title
	of community pages is constructed as NAMESPACE:Books/BOOKTITLE, where
	NAMESPACE depends on the value of $wgCommunityCollectionNamespace (see above).
	If the system message is set and its content is PREFIX, the title of community
	book pages is constructed by directly concatenating PREFIX and BOOKTITLE,
	i.e. there's no implicitly inserted '/' inbetween. Thus it's possible to
	define a custom namespace 'Book' and set the system message to 'Book:' to
	produce community book page titles Book:BOOKTITLE.

* Coll-savedbook_template: The name of the template (w/out the Template: prefix)
  included at the top of saved book pages (see above).
	The default is: 'saved_book', and there exist translations for lots of
	different languages.

* Coll-bookscategory: Name of a category (w/out the Category: prefix) to which
  all saved book pages should be added (optional, set to an empty value or "-"
	to turn that feature off).

* Coll-book_creator_text_article: The name of  a wiki page which is transcluded
  on the "Start book creator" page (the page which is shown when a user clicks
	on "Create a book").
	The default is: {{MediaWiki:Coll-helppage}}/Book creator text
	i.e. a subpage of the configured help page named "Book creator text"

* Coll-suggest_enabled: If set to 1, the suggestion tool is enabled. Any other
  value will disable the suggestion tool.
	The default is: '1', i.e. the suggestion tool is enabled.

* Coll-order_info_article: The name of a wiki page which is included on the
  Special:Book page to show order information for printed books.
	The default value is: {{MediaWiki:Coll-helppage}}/PediaPress order information
	i.e. a subpage of the configured help page named "PediaPress order information".

* Coll-rendering_page_info_text_article: The name of a wiki page with additional
  informations to be displayed when single pages are being rendered.

* Coll-rendering_collection_info_text_article: The name of a wiki page with additional
  informations to be displayed when collections are being rendered.


.. _mwlib: http://code.pediapress.com/wiki/wiki/mwlib
.. _MediaWiki: http://www.mediawiki.org/
.. _`PediaPress GmbH`: http://pediapress.com/
.. _`Wikimedia Foundation`: http://wikimediafoundation.org/
.. _`Commonwealth of Learning`: http://www.col.org/
.. _`MediaWiki API`: http://www.mediawiki.org/wiki/API
.. _`Meta-Wiki`: http://meta.wikimedia.org/wiki/Book_tool/Help/Books
