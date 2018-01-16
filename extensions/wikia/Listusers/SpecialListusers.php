<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named Listusers.\n";
	exit( 1 ) ;
}

$GLOBALS['wgExtensionCredits']['specialpage'][] = [
	"name" => "Local users",
	"description-msg" => "listusers-desc",
	"author" => "Piotr Molski",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Listusers',
];

/**
 * Messages
 */
$GLOBALS['wgExtensionMessagesFiles']['Listusers'] = __DIR__ . '/SpecialListusers.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['ListusersAlias'] = __DIR__ . '/SpecialListusers.alias.php';

$GLOBALS['wgAutoloadClasses']['EditCountService'] = __DIR__ . '/update/EditCountService.php';
$GLOBALS['wgAutoloadClasses']['ListUsersUpdate'] = __DIR__ . '/update/ListUsersUpdate.php';
$GLOBALS['wgAutoloadClasses']['ListUsersEditUpdate'] = __DIR__ . '/update/ListUsersEditUpdate.php';
$GLOBALS['wgAutoloadClasses']['UpdateListUsersTask'] = __DIR__ . '/update/UpdateListUsersTask.php';

/**
 * Helpers
 */
$GLOBALS['wgAutoloadClasses']['ListusersData']  = __DIR__ . '/SpecialListusers_helper.php';

/**
 * Hooks
 */
$GLOBALS['wgAutoloadClasses']['ListusersAjax'] = __DIR__ . '/SpecialListusers_ajax.php';
$GLOBALS['wgAutoloadClasses']['ListusersHooks'] = __DIR__ . '/SpecialListusers_hooks.php';

$GLOBALS['wgHooks']['SpecialPage_initList'][] = 'ListusersHooks::ActiveUsers';
$GLOBALS['wgAjaxExportList'][] = 'ListusersAjax::axShowUsers';
$GLOBALS['wgAjaxExportList'][] = 'ListusersAjax::axSuggestUsers';

$GLOBALS['wgHooks']['UserRights'][] = 'ListusersHooks::updateUserRights';
$GLOBALS['wgHooks']['NewRevisionFromEditComplete'][] = 'ListusersHooks::doEditUpdate';

/**
 * Special pages
 */
$GLOBALS['wgAutoloadClasses']['Listusers'] = __DIR__ . '/SpecialListusers_body.php';
$GLOBALS['wgAutoloadClasses']['SpecialListStaff'] = __DIR__ . '/SpecialListusers_body.php';
$GLOBALS['wgAutoloadClasses']['SpecialListVstf'] = __DIR__ . '/SpecialListusers_body.php';
$GLOBALS['wgAutoloadClasses']['SpecialListHelpers'] = __DIR__ . '/SpecialListusers_body.php';

$GLOBALS['wgSpecialPages']['Listusers'] = 'Listusers';
$GLOBALS['wgSpecialPages']['Liststaff'] = 'SpecialListStaff';
$GLOBALS['wgSpecialPages']['Listvstf'] = 'SpecialListVstf';
$GLOBALS['wgSpecialPages']['Listhelpers'] = 'SpecialListHelpers';

// Only add Listusers to Special:SpecialPages
$GLOBALS['wgSpecialPageGroups']['Listusers'] = 'users';

// Resources Loader module
$GLOBALS['wgResourceModules']['ext.wikia.ListUsers'] = [
	'scripts' => [
		'js/table.js'
	],
	'styles' => [
		'css/table.scss'
	],
	'dependencies' => [
		// SUS-3207 - for user names auto-suggest feature
		'jquery.ui.autocomplete',
		'jquery.dataTables',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Listusers'
];
