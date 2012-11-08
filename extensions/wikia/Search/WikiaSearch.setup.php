<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';

require( 'Solarium/Autoloader.php' );
Solarium_Autoloader::register();

/**
 * constants we want for search profiles
 */
if (! defined( 'SEARCH_PROFILE_DEFAULT' ) ) {
		define( 'SEARCH_PROFILE_DEFAULT', 'default' );
}
if (! defined( 'SEARCH_PROFILE_IMAGES' ) ) {
		define( 'SEARCH_PROFILE_IMAGES', 'images' );
}
if (! defined( 'SEARCH_PROFILE_USERS' ) ) {
		define( 'SEARCH_PROFILE_USERS', 'users' );
}
if (! defined( 'SEARCH_PROFILE_ALL' ) ) {
		define( 'SEARCH_PROFILE_ALL', 'all' );
}
if (! defined( 'SEARCH_PROFILE_ADVANCED' ) ) {
		define( 'SEARCH_PROFILE_ADVANCED', 'advanced' );
}

/**
 * classes
 */
$app->registerClass('WikiaSearch', 					$dir . 'WikiaSearch.class.php');
$app->registerClass('WikiaSearchIndexer', 			$dir . 'WikiaSearchIndexer.class.php');
$app->registerClass('WikiaSearchConfig', 			$dir . 'WikiaSearchConfig.class.php');
$app->registerClass('WikiaSearchController', 		$dir . 'WikiaSearchController.class.php');
$app->registerClass('WikiaSearchResult', 			$dir . 'WikiaSearchResult.class.php');
$app->registerClass('WikiaSearchResultSet', 		$dir . 'WikiaSearchResultSet.class.php');
$app->registerClass('WikiaSearchArticleMatch',		$dir . 'WikiaSearchArticleMatch.class.php');
$app->registerClass('WikiaSearchAjaxController',	$dir . 'WikiaSearchAjaxController.class.php');
$app->registerClass('WikiaVideoSearchController',	$dir . 'WikiaVideoSearchController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('WikiaSearch',	'WikiaSearchController');
$app->registerSpecialPage('Search',			'WikiaSearchController');

/**
 * Wikia API controllers
 */
$app->registerApiController( 'SearchApiController', "{$dir}SearchApiController.class.php" );

global $wgSolrProxy, $wgSolrHost, $wgWikiaSearchUseProxy, $wgExternalSharedDB, $wgEnableRelatedVideoSearch;

if (! empty( $wgEnableRelatedVideoSearch ) ) {
	$app->registerSpecialPage('VideoSearch',	'WikiaVideoSearchController');
}


$wgSolrHost = isset($_GET['solrhost']) ? $_GET['solrhost'] : $wgSolrHost;

if (isset($_GET['solrhost']) || isset($_GET['solrport'])) {
     $wgSolrPort = isset($_GET['solrport']) ? $_GET['solrport'] : 8983;

     $wgWikiaSearchUseProxy = false;
}

// some of this stuff can't be trusted evidently.
$wgSolrHost = $wgExternalSharedDB ? $wgSolrHost : 'staff-search-s1';
$wgSolrPort = $wgExternalSharedDB ? $wgSolrPort : 8983;
$wgSolrUseProxy = $wgExternalSharedDB ? !empty($wgSolrUseProxy) : false;
$wgWikiaSearchUseProxy = $wgExternalSharedDB ? $wgWikiaSearchUseProxy : false;

$solariumConfig = array(
		'adapteroptions'	=> array(
			'host' => ( !empty( $wgSolrHost ) ? $wgSolrHost : 'localhost'),
			'port' => ( !empty( $wgSolrPort ) ? $wgSolrPort : 8180 ),
			'path' => '/solr/',
		)
);

//@todo configs for this?
$searchMaster = $wgExternalSharedDB ? 'search-s6' : 'staff-search-s1';

$indexerSolariumConfig = array(
		'adapteroptions'	=> array(
			'host' => $searchMaster,
			'port' => 8983,
			'path' => '/solr/',
		)
);

if ($wgWikiaSearchUseProxy && isset($wgSolrProxy)) {
	$solariumConfig['adapteroptions']['proxy'] = $wgSolrProxy;
	$solariumConfig['adapteroptions']['port'] = null;
}

F::addClassConstructor( 'Solarium_Client', array( 'solariumConfig' => $solariumConfig ) );


F::addClassConstructor( 'WikiaSearch', array( 'client' => F::build('Solarium_Client') ) );
F::addClassConstructor( 'WikiaSearchIndexer', array( 'client' => F::build('Solarium_Client', array( 'solariumConfig' => $indexerSolariumConfig ) ) ) );

/**
 * message files
 */
$app->registerExtensionMessageFile('WikiaSearch', $dir . 'WikiaSearch.i18n.php' );

/**
 * preference settings
 */
$app->registerHook('GetPreferences', 'WikiaSearch', 'onGetPreferences');

/*
 * hooks
 */
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaSearchController', 'onWikiaMobileAssetsPackages');

if (! $wgExternalSharedDB ) {
	$app->registerHook('ArticleDeleteComplete', 'WikiaSearchIndexer', 'onArticleDeleteComplete');
	$app->registerHook('ArticleSaveComplete', 'WikiaSearchIndexer', 'onArticleSaveComplete');
	$app->registerHook('ArticleUndelete', 'WikiaSearchIndexer', 'onArticleUndelete');
}

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Search',
	'version'			=> '3.0',
	'author'			=> '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek], [http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-search-desc',
);
