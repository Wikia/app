<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';

require_once( $IP . '/lib/vendor/php-nlp-tools/autoloader.php' ); //@TODO find a better place for this
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
$wgAutoloadClasses['WikiaSearchController'] =  $dir . 'WikiaSearchController.class.php';
$wgAutoloadClasses['WikiaSearchIndexerController'] =  $dir . 'WikiaSearchIndexerController.class.php';
$wgAutoloadClasses['WikiaSearchAjaxController'] =  $dir . 'WikiaSearchAjaxController.class.php';

/**
 * special pages
 */
$wgSpecialPages['WikiaSearch'] = 'WikiaSearchController';
$wgSpecialPages['Search'] = 'WikiaSearchController';



/**
 * Wikia API controllers
 */
$app->registerApiController( 'SearchApiController', "{$dir}SearchApiController.class.php" );

/**
 * message files
 */
$wgExtensionMessagesFiles['WikiaSearch'] = $dir . 'WikiaSearch.i18n.php' ;

/**
 * preference settings
 */
$wgHooks['GetPreferences'][] = 'Wikia\Search\Hooks::onGetPreferences';

/**
 * hooks
 */
$wgHooks['WikiaMobileAssetsPackages'][] = 'Wikia\Search\Hooks::onWikiaMobileAssetsPackages';

global $wgExternalSharedDB;
if ( empty( $wgExternalSharedDB ) ) {
	$wgHooks['ArticleDeleteComplete'][] = 'Wikia\Search\Hooks::onArticleDeleteComplete';
	$wgHooks['ArticleSaveComplete'][] = 'Wikia\Search\Hooks::onArticleSaveComplete';
	$wgHooks['ArticleUndelete'][] = 'Wikia\Search\Hooks::onArticleUndelete';
} else {
	$wgHooks['WikiFactoryPublicStatusChange'][] = 'Wikia\Search\Hooks::onWikiFactoryPublicStatusChange';
}

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Search',
	'version'			=> '3.0',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-search-desc',
);
