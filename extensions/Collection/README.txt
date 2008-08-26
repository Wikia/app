.. -*- mode: rst; coding: utf-8 -*-

====================================
*Collection* Extension for MediaWiki
====================================

About the *Collection* Extension
================================

The *Collection* extension for MediaWiki_ allows users to collect articles and
generate PDFs for article collections and single articles.

The extension has been developed for and tested with MediaWiki_ version 1.11
and later.

The extension is being developed under the GNU General Public License by
`PediaPress GmbH`_ in close collaboration with `Wikimedia Foundation`_
and the `Commonwealth of Learning`_.

Copyright (C) 2008, PediaPress GmbH

Prerequisites
=============

Install PHP with cURL support
-----------------------------

Currently Collection extension needs PHP with cURL support,
see http://de2.php.net/manual/en/book.curl.php

Install and Setup a Render Server
---------------------------------

PDF and ZIP file generation is done by a server, which can run separately
from the MediaWiki installation and can be shared by different MediaWikis.
See the ``mw-serve`` command or the ``mwlib.cgi`` script in the mwlib_
distribution.

If you have a low-traffic MediaWiki you can use the public render server running
at http://tools.pediapress.com/mw-serve/. In this case, just keep
the configuration variable $wgCollectionMWServe (see below) at its default
value.


Installation and Configuration of the Collection Extension
==========================================================

* Checkout the *Collection* extension from the Subversion repository into the
  ``extensions`` directory of your *MediaWiki* installation::
  
    cd extensions/
    svn co http://svn.mediawiki.org/svnroot/mediawiki/trunk/extensions/Collection

* Put this line in your ``LocalSettings.php``::

    require_once("$IP/extensions/Collection/Collection.php");

  and set the following global variables accordingly:

  *$wgCollectionMWServeURL (string)*
   Set this to the URL of a render server (see above).
   
   The default is ``"http://tools.pediapress.com/mw-serve/"``,
   a public render server for low-traffic MediaWikis hosted by PediaPress.
   
   Note that the MediaWiki must be accessible from the render server, i.e. if
   your MediaWiki is behind a firewall you cannot use the public render server.
  
  *$wgCollectionMWServeCredentials (string)*
   Set this to a string of the form "USERNAME:PASSWORD", if the MediaWiki
   requires to be logged in to view articles.
   The render server will then login with these credentials using MediaWiki API
   before doing other requests.
   
   SECURITY NOTICE: If the MediaWiki and the render server communicate over an
   insecure channel (e.g. on an unencrypted channel over the internet), please
   DO NOT USE THIS SETTING, as the credentials will be exposed to eavesdropping!
  
  *$wgCollectionFormats*
   An array mapping names of mwlib_ writers to the name of the produces format.
   The default value is:
   
       array(
           'rl' => 'PDF',
       )
    
   i.e. only PDF enabled. See mwlib_ for possible other writers.
   
  *$wgCommunityCollectionNamespace (integer)*
   Namespace for "community collections", i.e. the namespace where non-personal
   article collection pages are saved.
   
   Example: If you keep the default, ``NS_MEDIAWIKI`` and have a non-localized
   (i.e. English) *MediaWiki* installation, collections are saved as subpages of
   ``MediaWiki:Collections``.
   
   Default is ``NS_MEDIAWIKI``.
  
  *$wgCollectionMaxArticles (integer)*
   Maximum number of articles allowed in a collection.
   
   Default is 500.
  
  *$wgLicenseName (string or null)*
   License name for articles in this MediaWiki.
   If set to ``null`` the localized version of the word "License" is used.
   
   Default is null.
  
  *$wgLicenseURL (string or null)*
   HTTP URL of an article containing the full license text in wikitext format
   for articles in this MediaWiki. E.g.
   
       $wgLicenseURL = 'http://en.wikipedia.org/w/index.php?title=Wikipedia:Text_of_the_GNU_Free_Documentation_License&action=raw';

   for the GFDL.
   If set to null, the standard MediaWiki variables $wgRightsPage,
   $wgRightsUrl and $wgRightsText are used for license information.
   
   If your MediaWiki contains articles with different licenses, make sure
   that each article contains the name of the license and set $wgLicenseURL
   to an article that contains all needed licenses.
   
  *$wgPDFTemplateBlackList (string)*
   Title of an article containing blacklisted templates, i.e. templates that
   should be excluded for PDF generation.

   Default value is ``"MediaWiki:PDF Template Blacklist"``

   The template blacklist page should contain a list of links to the
   blacklisted templates in the following form::
   
	 * [[Template:Templatename]]
	 * [[Template:SomeOtherTemplatename]]
	 
   
   
* Add a portlet to the skin of your *MediaWiki* installation: Just before the line::

    <div class="portlet" id="p-tb">

  in the file ``skins/MonoBook.php`` or ``skins/Modern.php`` insert
  the following code::

    <?php
      if(isset($GLOBALS['wgSpecialPages']['Collection'])) {
         Collection::printPortlet();
      }
    ?>

* As the current collection of articles is stored in the session, the session
  timeout should be set to some sensible value (at least a few hours, maybe
  one day). Adjust session.cookie_lifetime and session.gc_maxlifetime in your
  ``php.ini`` accordingly.

* Add a page ``Help:Collections`` with the wikitext from the supplied file
  ``Help_Collections.txt``. Adjust the name of the template blacklist according
  to your setting of $wgPDFTemplateBlackList (see above).

.. _mwlib: http://code.pediapress.com/wiki/wiki/mwlib
.. _MediaWiki: http://www.mediawiki.org/
.. _`PediaPress GmbH`: http://pediapress.com/
.. _`Wikimedia Foundation`: http://wikimediafoundation.org/
.. _`Commonwealth of Learning`: http://www.col.org/
