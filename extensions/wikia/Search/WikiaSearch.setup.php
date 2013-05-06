<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';

require_once( $IP . '/lib/vendor/Solarium/Autoloader.php' );
require_once( $IP . '/lib/vendor/simplehtmldom/simple_html_dom.php' );
Solarium_Autoloader::register();

/**
 * constants we want for search profiles
 */
define( 'SEARCH_PROFILE_DEFAULT',  'default' );
define( 'SEARCH_PROFILE_IMAGES',   'images' );
define( 'SEARCH_PROFILE_USERS',    'users' );
define( 'SEARCH_PROFILE_ALL',      'all' );
define( 'SEARCH_PROFILE_ADVANCED', 'advanced' );

// autoloads values in the search namespace
spl_autoload_register( function( $class ) {
	if ( substr_count( $class, 'Wikia\\Search\\' ) > 0 ) {
		$class = preg_replace( '/\\\\?Wikia\\\\Search\\\\/', '', $class );
		$file = __DIR__ . '/classes/'.strtr( $class, '\\', '/' ).'.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
			return true;
		}
		return false;
	}
});

/**
 * Keeping the traditional controller registry for now
 */
$app->registerClass('WikiaSearchController', $dir . 'WikiaSearchController.class.php');
$app->registerClass('WikiaSearchIndexerController', $dir . 'WikiaSearchIndexerController.class.php');
$app->registerClass('WikiaSearchAjaxController', $dir . 'WikiaSearchAjaxController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('WikiaSearch',	'WikiaSearchController');
$app->registerSpecialPage('Search',			'WikiaSearchController');



/**
 * Wikia API controllers
 */
$app->registerApiController( 'SearchApiController', "{$dir}SearchApiController.class.php" );

/**
 * message files
 */
$app->registerExtensionMessageFile('WikiaSearch', $dir . 'WikiaSearch.i18n.php' );

/**
 * preference settings
 */
$app->registerHook('GetPreferences', 'Wikia\Search\Hooks', 'onGetPreferences');

/**
 * hooks
 */
$app->registerHook('WikiaMobileAssetsPackages', 'Wikia\Search\Hooks', 'onWikiaMobileAssetsPackages');

global $wgExternalSharedDB;
if ( empty( $wgExternalSharedDB ) ) {
	$app->registerHook('ArticleDeleteComplete', 'Wikia\Search\Hooks', 'onArticleDeleteComplete');
	$app->registerHook('ArticleSaveComplete', 'Wikia\Search\Hooks', 'onArticleSaveComplete');
	$app->registerHook('ArticleUndelete', 'Wikia\Search\Hooks', 'onArticleUndelete');
} else {
	$app->registerHook('WikiFactoryPublicStatusChange', 'Wikia\Search\Hooks', 'onWikiFactoryPublicStatusChange');
}

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Search',
	'version'			=> '3.0',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-search-desc',
);
