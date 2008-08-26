<?php
/*
 * Copyright 2004-2007 River Tarnell, Brion Vibber.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * $Id: LuceneSearch.php 584 2008-07-29 13:59:13Z emil $
 */

# To use this, add something like the following to LocalSettings:
#
#  $wgDisableInternalSearch = true;
#  $wgLuceneHost = "192.168.0.1";
#  $wgLucenePort = 8123;
#
#  require_once("../extensions/LuceneSearch.php");
#
# To load-balance with from multiple servers:
#
#  $wgLuceneHost = array( "192.168.0.1", "192.168.0.2" );
#
# The MWDaemon search daemon needs to be running on the specified host(s)
# - it's in the 'mwsearch' module in CVS.
##########

$wgLuceneDisableSuggestions = true;
$wgLuceneDisableTitleMatches = false;

/** Number of seconds to cache query results */
$wgLuceneCacheExpiry = 60 * 15;

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	die( "This file is part of MediaWiki, it is not a valid entry point\n" );
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'LuceneSearch',
	'version'        => '2.0',
	'author'         => array( 'Brion Vibber', 'Robert Stojnić' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LuceneSearch',
	'description'    => 'Interface for the Apache Lucene search engine',
	'descriptionmsg' => 'lucene-desc',
);

/** Lucene-search (mwsearch) version. from 2.0 we support search prefixes */
$wgLuceneSearchVersion = 1.0;

/** Show additional "exact case" search button,
 index needs to be built with exact case option */
$wgLuceneSearchExactCase = false;


# Internationalisation file
require_once( 'LuceneSearch.i18n.php' );

if (class_exists('Revision'))
	$wgLSuseold = false;
else
	$wgLSuseold = true;

define('LS_PER_PAGE', 10);

if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}

extAddSpecialPage( dirname(__FILE__) . '/LuceneSearch_body.php', 'Search', 'LuceneSearch' );

$wgExtensionMessagesFiles['LuceneSearch'] = dirname(__FILE__) . '/LuceneSearch.i18n.php';
$wgAutoloadClasses['LuceneResult'] = dirname(__FILE__) . '/LuceneSearch_body.php';

$wgAutoloadClasses['ApiQueryLuceneSearch'] = dirname(__FILE__) . '/ApiQueryLuceneSearch.php';
// Override the default search engine
$wgApiQueryListModules['search'] = 'ApiQueryLuceneSearch';

