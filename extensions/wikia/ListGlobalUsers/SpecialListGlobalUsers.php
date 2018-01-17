<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jarek Cellary
 * @copyright (C) 2049, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named ListGlobalUsers.\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	"name" => "Global users",
	"description-msg" => "listglobalusers-desc",
	"author" => "Jarek Cellary",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ListGlobalUsers'
);

/**
 * Messages
 */
$wgExtensionMessagesFiles['ListGlobalUsers'] = __DIR__ . '/SpecialListGlobalUsers.i18n.php';

/**
 * Helpers
 */
$wgAutoloadClasses['ListGlobalUsersData']  = __DIR__ . '/SpecialListGlobalUsers_helper.php';

/**
 * Hooks
 */
$wgAutoloadClasses['ListGlobalUsersAjax'] = __DIR__ . '/SpecialListGlobalUsers_ajax.php';

$wgAjaxExportList[] = 'ListGlobalUsersAjax::axShowUsers';
$wgAjaxExportList[] = 'ListGlobalUsersAjax::axSuggestUsers';

/**
 * Special pages
 */
$wgAutoloadClasses['ListGlobalUsers'] = __DIR__ . '/SpecialListGlobalUsers_body.php';
$wgAutoloadClasses['SpecialListStaff'] = __DIR__ . '/SpecialListGlobalUsers_body.php';
$wgAutoloadClasses['SpecialListVstf'] = __DIR__ . '/SpecialListGlobalUsers_body.php';
$wgAutoloadClasses['SpecialListHelpers'] = __DIR__ . '/SpecialListGlobalUsers_body.php';

$wgSpecialPages['ListGlobalUsers'] = 'ListGlobalUsers';

$wgSpecialPageGroups['ListGlobalUsers'] = 'users';

// Resources Loader module
$wgResourceModules['ext.wikia.ListGlobalUsers'] = [
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
	'remoteExtPath' => 'wikia/ListGlobalUsers'
];
