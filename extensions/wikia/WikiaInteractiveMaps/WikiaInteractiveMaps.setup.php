<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Wikia Interactive Maps',
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
$wgAutoloadClasses[ 'WikiaInteractiveMapsController' ] = $dir . '/controllers/WikiaInteractiveMapsController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsParserTagController' ] = $dir . '/controllers/WikiaInteractiveMapsParserTagController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsBaseController' ] = $dir . '/controllers/WikiaInteractiveMapsBaseController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsMapController' ] = $dir . '/controllers/WikiaInteractiveMapsMapController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsPoiController' ] = $dir . '/controllers/WikiaInteractiveMapsPoiController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsPoiCategoryController' ] = $dir . '/controllers/WikiaInteractiveMapsPoiCategoryController.class.php';

// helper classes
$wgAutoloadClasses[ 'WikiaInteractiveMapsHooks' ] = $dir . 'WikiaInteractiveMapsHooks.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsUploadImageFromFile' ] = $dir . 'WikiaInteractiveMapsUploadImageFromFile.class.php';

// model classes
$wgAutoloadClasses[ 'WikiaMaps' ] = $dir . '/models/WikiaMaps.class.php';
$wgAutoloadClasses[ 'WikiaMapsLogger' ] = $dir . '/models/WikiaMapsLogger.class.php';

// exception classes
$wgAutoloadClasses[ 'WikiaInteractiveMapsPermissionException' ] = $dir . '/exceptions/WikiaInteractiveMapsPermissionException.class.php';

// special pages
$wgSpecialPages[ 'Maps' ] = 'WikiaInteractiveMapsController';
$wgSpecialPageGroups[ 'Maps' ] = 'wikia';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'WikiaInteractiveMapsParserTagController::parserTagInit';
$wgHooks[ 'OutputPageBeforeHTML' ][] = 'WikiaInteractiveMapsHooks::onOutputPageBeforeHTML';
$wgHooks[ 'OasisSkinAssetGroups' ][] = 'WikiaInteractiveMapsHooks::onOasisSkinAssetGroups';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'WikiaInteractiveMapsHooks::onSkinAfterBottomScripts';

// mobile
$wgHooks['WikiaMobileAssetsPackages'][] = 'WikiaInteractiveMapsHooks::onWikiaMobileAssetsPackages';

// i18n mapping
$wgExtensionMessagesFiles[ 'WikiaInteractiveMaps' ] = $dir . 'WikiaInteractiveMaps.i18n.php';

JSMessages::registerPackage( 'WikiaInteractiveMaps', [
	'wikia-interactive-maps-map-placeholder-error'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsCreateMap', [
	'wikia-interactive-maps-create-map-*'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsPoiCategories', [
	'wikia-interactive-maps-poi-categories-*'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsEditPOI', [
	'wikia-interactive-maps-edit-poi-*'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsDeleteMap', [
	'wikia-interactive-maps-delete-map-client-*'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsEmbedMapCode', [
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
