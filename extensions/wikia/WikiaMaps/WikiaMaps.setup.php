<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Wikia Maps',
	'author' => [
		'Andrzej "nAndy" Łukaszewski',
		'Bartłomiej "Bart" Kowalczyk',
		'Evgeniy "aquilax" Vasilev',
		'Igor Rogatty',
		'Jakub "Student" Olek',
		'Rafał Leszczyński'
	],
	'descriptionmsg' => 'wikia-interactive-maps-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaMaps'
];

// controller classes
$wgAutoloadClasses[ 'WikiaMapsSpecialController' ] = $dir . 'controllers/WikiaMapsSpecialController.class.php';
$wgAutoloadClasses[ 'WikiaMapsParserTagController' ] = $dir . 'controllers/WikiaMapsParserTagController.class.php';
$wgAutoloadClasses[ 'WikiaMapsBaseController' ] = $dir . 'controllers/WikiaMapsBaseController.class.php';
$wgAutoloadClasses[ 'WikiaMapsMapController' ] = $dir . 'controllers/WikiaMapsMapController.class.php';
$wgAutoloadClasses[ 'WikiaMapsPoiController' ] = $dir . 'controllers/WikiaMapsPoiController.class.php';
$wgAutoloadClasses[ 'WikiaMapsPoiCategoryController' ] = $dir . 'controllers/WikiaMapsPoiCategoryController.class.php';

// helper classes
$wgAutoloadClasses[ 'WikiaMapsHooks' ] = $dir . 'WikiaMapsHooks.class.php';
$wgAutoloadClasses[ 'WikiaMapsUploadImageFromFile' ] = $dir . 'WikiaMapsUploadImageFromFile.class.php';

// model classes
$wgAutoloadClasses[ 'WikiaMaps' ] = $dir . 'models/WikiaMaps.class.php';
$wgAutoloadClasses[ 'WikiaMapsLogger' ] = $dir . 'models/WikiaMapsLogger.class.php';

// exception classes
$wgAutoloadClasses[ 'WikiaMapsPermissionException' ] = $dir . 'exceptions/WikiaMapsPermissionException.class.php';
$wgAutoloadClasses[ 'WikiaMapsConfigException' ] = $dir . 'exceptions/WikiaMapsConfigException.class.php';

// special pages
$wgSpecialPages[ 'Maps' ] = 'WikiaMapsSpecialController';
$wgSpecialPageGroups[ 'Maps' ] = 'wikia';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'WikiaMapsParserTagController::onParserFirstCallInit';
$wgHooks[ 'OasisSkinAssetGroups' ][] = 'WikiaMapsHooks::onOasisSkinAssetGroups';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'WikiaMapsHooks::onSkinAfterBottomScripts';
$wgHooks[ 'BeforePageDisplay' ][] = 'WikiaMapsHooks::onBeforePageDisplay';

// mobile
$wgHooks['WikiaMobileAssetsPackages'][] = 'WikiaMapsHooks::onWikiaMobileAssetsPackages';

/**
 * Register resource loader packega for parser tag
 */
$wgResourceModules['ext.wikia.WikiaMaps.ParserTag'] = [
	'skinStyles' => [
		'oasis' => [
			'css/WikiaMapsParserTag.scss'
		]
	],
	'skinScripts' => [
		'oasis' => [
			'js/WikiaMapsParserTag.js'
		]
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/WikiaMaps'
];

// i18n mapping
$wgExtensionMessagesFiles[ 'WikiaMaps' ] = $dir . 'WikiaMaps.i18n.php';
$wgExtensionMessagesFiles[ 'WikiaMapsAliases' ] = $dir . 'WikiaMaps.aliases.php';

JSMessages::registerPackage( 'WikiaMaps', [
	'wikia-interactive-maps-map-placeholder-error'
] );

JSMessages::registerPackage( 'WikiaMapsCreateMap', [
	'wikia-interactive-maps-create-map-*'
] );

JSMessages::registerPackage( 'WikiaMapsPoiCategories', [
	'wikia-interactive-maps-poi-categories-*'
] );

JSMessages::registerPackage( 'WikiaMapsPoi', [
	'wikia-interactive-maps-edit-poi-*'
] );

JSMessages::registerPackage( 'WikiaMapsDeleteMap', [
	'wikia-interactive-maps-delete-map-client-*'
] );

JSMessages::registerPackage( 'WikiaMapsEmbedMapCode', [
	'wikia-interactive-maps-embed-map-code-*'
] );

// Logs
$wgLogTypes[] = 'maps';
$wgLogNames['maps'] = 'wikia-interactive-maps-log-name';
$wgLogHeaders['maps'] = 'wikia-interactive-maps-log-description';
$wgLogActionsHandlers[ 'maps/*' ] = 'LogFormatter';
