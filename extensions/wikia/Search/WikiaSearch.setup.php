<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */

$dir = __DIR__ . '/';

/**
 * constants we want for search profiles
 */
define( 'SEARCH_PROFILE_DEFAULT', 'default' );
define( 'SEARCH_PROFILE_IMAGES', 'images' );
define( 'SEARCH_PROFILE_USERS', 'users' );
define( 'SEARCH_PROFILE_ALL', 'all' );
define( 'SEARCH_PROFILE_ADVANCED', 'advanced' );

/**
 * Keeping the traditional controller registry for now
 */
$wgAutoloadClasses['WikiaSearchController'] = $dir . 'WikiaSearchController.class.php';
$wgAutoloadClasses['WikiaSearchIndexerController'] = $dir . 'WikiaSearchIndexerController.class.php';
$wgAutoloadClasses['WikiaSearchAjaxController'] = $dir . 'WikiaSearchAjaxController.class.php';
$wgAutoloadClasses['WikiaSearchHelper'] = $dir . 'WikiaSearchHelper.class.php';

/**
 * special pages
 */
$wgSpecialPages['WikiaSearch'] = 'WikiaSearchController';
$wgSpecialPages['Search'] = 'WikiaSearchController';

/**
 * Wikia API controllers
 */
$wgAutoloadClasses['SearchApiController'] = $dir . 'SearchApiController.class.php';
$wgWikiaApiControllers['SearchApiController'] = $dir . 'SearchApiController.class.php';

/**
 * message files
 */
$wgExtensionMessagesFiles['WikiaSearch'] = $dir . 'WikiaSearch.i18n.php';

/**
 * preference settings
 */
$wgHooks['GetPreferences'][] = 'Wikia\Search\Hooks::onGetPreferences';

/**
 * hooks
 */
$wgHooks['WikiaMobileAssetsPackages'][] = 'Wikia\Search\Hooks::onWikiaMobileAssetsPackages';

$wgHooks['WikiFactoryPublicStatusChange'][] = 'Wikia\Search\Hooks::onWikiFactoryPublicStatusChange';

$wgExtensionCredits['other'][] = [
	'name' => 'Wikia Search',
	'version' => '3.0',
	'author' => '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg' => 'wikia-search-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Search'
];
