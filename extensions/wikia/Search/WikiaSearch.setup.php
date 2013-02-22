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

require_once( 'Solarium/Autoloader.php' );
require_once( dirname(__FILE__). '/../../../lib/simplehtmldom/simple_html_dom.php' );
Solarium_Autoloader::register();

/**
 * constants we want for search profiles
 */
define( 'SEARCH_PROFILE_DEFAULT',  'default' );
define( 'SEARCH_PROFILE_IMAGES',   'images' );
define( 'SEARCH_PROFILE_USERS',    'users' );
define( 'SEARCH_PROFILE_ALL',      'all' );
define( 'SEARCH_PROFILE_ADVANCED', 'advanced' );

/**
 * classes
 */
$app->registerClass('WikiaSearch', 					$dir . 'WikiaSearch.class.php');
$app->registerClass('WikiaSearchIndexer', 			$dir . 'WikiaSearchIndexer.class.php');
$app->registerClass('WikiaSearchConfig', 			$dir . 'WikiaSearchConfig.class.php');
$app->registerClass('WikiaSearchController', 		$dir . 'WikiaSearchController.class.php');
$app->registerClass('WikiaSearchIndexerController', $dir . 'WikiaSearchIndexerController.class.php');
$app->registerClass('WikiaSearchResult', 			$dir . 'WikiaSearchResult.class.php');
$app->registerClass('WikiaSearchResultSet', 		$dir . 'WikiaSearchResultSet.class.php');
$app->registerClass('WikiaSearchArticleMatch',		$dir . 'WikiaSearchArticleMatch.class.php');
$app->registerClass('WikiaSearchWikiMatch',    		$dir . 'WikiaSearchWikiMatch.class.php');
$app->registerClass('WikiaSearchAjaxController',	$dir . 'WikiaSearchAjaxController.class.php');
$app->registerClass('WikiaVideoSearchController',	$dir . 'WikiaVideoSearchController.class.php');

// autoloads values in the search namespace
spl_autoload_register( function( $class ) {
	if ( substr_count( $class, 'Wikia\\Search\\' ) > 0 ) {
		$class = preg_replace( '/\\\\?Wikia\\\\Search\\\\/', '', $class );
		$file = __DIR__ . '/classes/'.strtr( $class, '\\', '/' ).'.php';
		require_once( $file );
		return true;
	}  
});


/**
 * special pages
 */
$app->registerSpecialPage('WikiaSearch',	'WikiaSearchController');
$app->registerSpecialPage('Search',			'WikiaSearchController');

/**
 * Wikia API controllers
 */
$app->registerApiController( 'SearchApiController', "{$dir}SearchApiController.class.php" );

global $wgSolrProxy, $wgSolrHost, $wgWikiaSearchUseProxy, $wgExternalSharedDB, $wgEnableRelatedVideoSearch, $wgSolrMaster;

// Special:VideoSearch - Page for testing different search methods.  Has nothing to do with RelatedVideos
if (! empty( $wgEnableRelatedVideoSearch ) ) {
	$app->registerSpecialPage('VideoSearch', 'WikiaVideoSearchController');
}


$wgSolrHost = isset($_GET['solrhost']) ? $_GET['solrhost'] : $wgSolrHost;

if (isset($_GET['solrhost']) || isset($_GET['solrport'])) {
     $wgSolrPort = isset($_GET['solrport']) ? $_GET['solrport'] : 8983;

     $wgWikiaSearchUseProxy = false;
}

// some of this stuff can't be trusted evidently.
$wgSolrHost = !empty( $wgExternalSharedDB ) ? $wgSolrHost : 'staff-search-s1';
$wgSolrMaster = !empty( $wgExternalSharedDB ) ? $wgSolrMaster : 'staff-search-s1';
$wgSolrPort = !empty( $wgExternalSharedDB ) ? $wgSolrPort : 8983;
$wgSolrUseProxy = $wgExternalSharedDB ? !empty($wgSolrUseProxy) : false;
$wgWikiaSearchUseProxy = $wgExternalSharedDB ? $wgWikiaSearchUseProxy : false;

$solariumConfig = array(
		'adapteroptions'	=> array(
			'host' => ( !empty( $wgSolrHost ) ? $wgSolrHost : 'localhost'),
			'port' => ( !empty( $wgSolrPort ) ? $wgSolrPort : 8180 ),
			'path' => '/solr/',
		)
);

$indexerSolariumConfig = array(
		'adapteroptions'	=> array(
			'host' => $wgSolrMaster,
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
$app->registerHook('GetPreferences', 'Wikia\Search\Hooks', 'onGetPreferences');

/*
 * hooks
 */
$app->registerHook('WikiaMobileAssetsPackages', 'Wikia\Search\Hooks', 'onWikiaMobileAssetsPackages');

if ( empty( $wgExternalSharedDB ) ) {
	$app->registerHook('ArticleDeleteComplete', 'WikiaSearchIndexer', 'onArticleDeleteComplete');
	$app->registerHook('ArticleSaveComplete', 'WikiaSearchIndexer', 'onArticleSaveComplete');
	$app->registerHook('ArticleUndelete', 'WikiaSearchIndexer', 'onArticleUndelete');
} else {
	$app->registerHook('WikiFactoryPublicStatusChange', 'WikiaSearchIndexer', 'onWikiFactoryPublicStatusChange');
}

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Search',
	'version'			=> '3.0',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-search-desc',
);
