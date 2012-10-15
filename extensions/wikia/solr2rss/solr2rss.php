<?php
/**
 * solr2rss concept redesigned as mediawiki extension (@see: solr2rss.old.php)
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'solr2rss',
	'author' => 'Adrian \'ADi\' Wieczorek',
	'url' => 'http://www.wikia.com' ,
	'description' => 'Fetch solr search results and convert to RSS'
);

/**
 * Special pages
 */
extAddSpecialPage(dirname(__FILE__) . '/SpecialSolr2rss.php', 'solr2rss', 'solr2rss');

