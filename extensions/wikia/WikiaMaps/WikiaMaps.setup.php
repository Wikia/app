<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Wikia Maps',
	'author' => [
		'Andrzej "nAndy" Łukaszewski',
		'Bartłomiej "Bart" Kowalczyk',
		'Evgeniy "aquilax" Vasilev',
		'Jakub "Student" Olek',
		'Rafał Leszczyński',
		'Igor Rogatty'
	],
	'description' => 'Create your own maps with point of interest or add your own point of interest into a real world map',
	'version' => 0.1
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
$wgHooks[ 'ParserFirstCallInit' ][] = 'WikiaMapsParserTagController::parserTagInit';
$wgHooks[ 'OutputPageBeforeHTML' ][] = 'WikiaMapsHooks::onOutputPageBeforeHTML';
$wgHooks[ 'OasisSkinAssetGroups' ][] = 'WikiaMapsHooks::onOasisSkinAssetGroups';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'WikiaMapsHooks::onSkinAfterBottomScripts';

// mobile
$wgHooks['WikiaMobileAssetsPackages'][] = 'WikiaMapsHooks::onWikiaMobileAssetsPackages';

// i18n mapping
$wgExtensionMessagesFiles[ 'WikiaMaps' ] = $dir . 'WikiaMaps.i18n.php';

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

$logActionsHandler = 'WikiaMapsLogger::formatLogEntry';

$wgLogActionsHandlers[ 'maps/create_map' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/update_map' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/delete_map' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/undelete_map' ] = $logActionsHandler;

$wgLogActionsHandlers[ 'maps/create_pin_type' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/update_pin_type' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/delete_pin_type' ] = $logActionsHandler;

$wgLogActionsHandlers[ 'maps/create_pin' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/update_pin' ] = $logActionsHandler;
$wgLogActionsHandlers[ 'maps/delete_pin' ] = $logActionsHandler;
