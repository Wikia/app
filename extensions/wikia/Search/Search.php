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
