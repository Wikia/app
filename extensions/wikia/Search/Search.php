<?php
/**
 * Wikia Search Extension - cross-Wikia search engine using Solr backend (based on MWSearch)
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$wgSearchType = 'SolrSearch';
$wgSolrHost = '10.8.2.16';
$wgSolrPort = '8983';

# To load-balance with from multiple servers:
#
#  $wgLuceneHost = array( "192.168.0.1", "192.168.0.2" );

# Back-end version; set to 2.1 to add support for some advanced features.
//$wgLuceneSearchVersion = 2;

# If to show related links (if available) below search results
//$wgLuceneUseRelated = false;

# If to use lucene as a prefix search backend
//$wgEnableLucenePrefixSearch = false;

# For how long (in seconds) to cache lucene results, off by default (0)
# NOTE: caching is typically inefficient for queries, with cache
# hit rates way below 1% even for very long expiry times
//$wgLuceneSearchCacheExpiry = 0;

# timeout for search backend to respond
//$wgLuceneSearchTimeout = 6;

$wgExtensionCredits['other'][] = array(
	'name'        => 'Wikia Search',
	'version'     => '0.1',
	'author'      => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'description' => 'cross-Wikia search engine using Solr backend'
);

$dir = dirname(__FILE__) . '/';

require_once( $dir . 'SolrPhpClient/Apache/Solr/Service.php' );

//$wgExtensionMessagesFiles['WikiaSearch'] = $dir . 'Search.i18n.php';

$wgAutoloadClasses['SolrSearch'] = $dir . 'Search_body.php';
$wgAutoloadClasses['SolrResult'] = $dir . 'Search_body.php';
$wgAutoloadClasses['SolrSearchSet'] = $dir . 'Search_body.php';

$wgHooks['SpecialSearchMakeHitLink'][] = 'SolrResult::makeHitLink';
