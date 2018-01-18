<?php

$GLOBALS['wgAutoloadClasses']['GlobalUsersService'] = __DIR__ . '/GlobalUsersService.php';
$GLOBALS['wgAutoloadClasses']['CachedGlobalUsersService'] = __DIR__ . '/CachedGlobalUsersService.php';
$GLOBALS['wgAutoloadClasses']['DatabaseGlobalUsersService'] = __DIR__ . '/DatabaseGlobalUsersService.php';

$GLOBALS['wgAutoloadClasses']['SpecialListStaff'] = __DIR__ . '/alias/SpecialListStaff.php';
$GLOBALS['wgAutoloadClasses']['SpecialListVstf'] = __DIR__ . '/alias/SpecialListVstf.php';
$GLOBALS['wgAutoloadClasses']['SpecialListHelpers'] = __DIR__ . '/alias/SpecialListHelpers.php';

$GLOBALS['wgAutoloadClasses']['SpecialListGlobalUsersController'] = __DIR__ . '/SpecialListGlobalUsersController.php';

$GLOBALS['wgSpecialPages']['ListGlobalUsers'] = 'SpecialListGlobalUsersController';
$GLOBALS['wgSpecialPageGroups']['ListGlobalUsers'] = 'users';

// aliases
$GLOBALS['wgSpecialPages']['ListStaff'] = 'SpecialListStaff';
$GLOBALS['wgSpecialPages']['ListVstf'] = 'SpecialListVstf';
$GLOBALS['wgSpecialPages']['ListHelpers'] = 'SpecialListHelpers';

$GLOBALS['wgResourceModules']['ext.wikia.ListGlobalUsers'] = [
	'scripts' => [ 'ext.wikia.ListGlobalUsers.js' ],
	'styles' => [ 'ext.wikia.ListGlobalUsers.css' ],
	'messages' => [
		'listglobalusers-select-all',
		'listglobalusers-deselect-all',
	],
	'dependencies' => [],

	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'extensions/ListGlobalUsers',
];
