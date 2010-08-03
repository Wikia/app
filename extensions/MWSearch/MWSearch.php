<?php
/*
 * Copyright 2004, 2005 Kate Turner, Brion Vibber.
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
 * $Id: MWSearch.php 45173 2008-12-30 04:10:29Z brion $
 */

# To use this, add something like the following to LocalSettings:
#
#  require_once("extensions/MWSearch/MWSearch.php");
# 
#  $wgSearchType = 'LuceneSearch';
#  $wgLuceneHost = '192.168.0.1';
#  $wgLucenePort = 8123;
#
# To load-balance with from multiple servers:
#
#  $wgLuceneHost = array( "192.168.0.1", "192.168.0.2" );
#
# The MWDaemon search daemon needs to be running on the specified host(s)
# - it's in the 'lucene-search' and 'mwsearch' modules in CVS.
##########


# Back-end version; set to 2.1 to add support for some advanced features.
$wgLuceneSearchVersion = 2;
	
# If to show related links (if available) below search results
$wgLuceneUseRelated = false;

# If to use lucene as a prefix search backend
$wgEnableLucenePrefixSearch = false;
	
# For how long (in seconds) to cache lucene results, off by default (0)
# NOTE: caching is typically inefficient for queries, with cache 
# hit rates way below 1% even for very long expiry times
$wgLuceneSearchCacheExpiry = 0;

# timeout for search backend to respond
$wgLuceneSearchTimeout = 6;

$wgExtensionCredits['other'][] = array(
	'name'           => 'MWSearch',
	'svn-date' => '$LastChangedDate: 2008-12-30 05:10:29 +0100 (wto, 30 gru 2008) $',
	'svn-revision' => '$LastChangedRevision: 45173 $',
	'author'         => array( 'Kate Turner', 'Brion Vibber' ),
	'descriptionmsg' => 'mwsearch-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:MWSearch',
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['MWSearch'] = $dir . 'MWSearch.i18n.php';
$wgExtensionFunctions[] = 'efLucenePrefixSetup';

$wgAutoloadClasses['LuceneSearch'] = $dir . 'MWSearch_body.php';
$wgAutoloadClasses['LuceneResult'] = $dir . 'MWSearch_body.php';
$wgAutoloadClasses['LuceneSearchSet'] = $dir . 'MWSearch_body.php';

function efLucenePrefixSetup() {
	global $wgHooks, $wgLuceneSearchVersion, $wgEnableLucenePrefixSearch;
	if($wgLuceneSearchVersion >= 2.1 && $wgEnableLucenePrefixSearch)
		$wgHooks['PrefixSearchBackend'][] = 'LuceneSearch::prefixSearch';
}
