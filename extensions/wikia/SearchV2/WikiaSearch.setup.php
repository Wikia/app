<?php
/**
 * Wikia Search (v2) Extension
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';


/**
 * classes
 */
$app->registerClass('WikiaSearch', $dir . 'WikiaSearch.class.php');
$app->registerClass('WikiaSearchClient', $dir . 'WikiaSearchClient.class.php');
$app->registerClass('WikiaSearchController', $dir . 'WikiaSearchController.class.php');
$app->registerClass('WikiaSearchResult', $dir . 'WikiaSearchResult.class.php');
$app->registerClass('WikiaSearchResultSet', $dir . 'WikiaSearchResultSet.class.php');
$app->registerClass('WikiaSolrClient', $dir . 'WikiaSolrClient.class.php');

/**
 * special pages
 */
if ($wgWikiaSearchIsDefault) {
     $app->registerSpecialPage('Search', 'WikiaSearchController');
}
$app->registerSpecialPage('WikiaSearch', 'WikiaSearchController');
$app->registerSpecialPage('Search', 'WikiaSearchController');

$wgSolrHost = isset($_GET['solrhost']) ? $_GET['solrhost'] : $wgSolrHost;

if (isset($_GET['solrhost']) || isset($_GET['solrport'])) {
     $wgSolrPort = isset($_GET['solrport']) ? $_GET['solrport'] : 8983;

     global $wikiaSearchUseProxy;
     $wgWikiaSearchUseProxy = false;
}

F::addClassConstructor( 'WikiaSolrClient',
	array(
	 'solrHost' => ( !empty( $wgSolrHost ) ? $wgSolrHost : 'localhost' ),
	 'solrPort' => ( !empty( $wgSolrPort ) ? $wgSolrPort : 8180 )
	));


F::addClassConstructor( 'WikiaSearch', array( 'client' => F::build('WikiaSolrClient') ) );

/**
 * message files
 */
$app->registerExtensionMessageFile('WikiaSearch', $dir . 'WikiaSearch.i18n.php' );

/**
 * preference settings
 */
$app->registerHook('GetPreferences', 'WikiaSearch', 'onGetPreferences');


$wgExtensionCredits['other'][] = array(
	'name'        => 'Wikia Search V2',
	'version'     => '2.0.5',
	'author'      => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'descriptionmsg' => 'wikia-search-desc',
);
