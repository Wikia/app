<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Wikia Interactive Maps',
	'author' => [
		'Andrzej "nAndy" Łukaszewski',
		'Bart(łomey) K.',
		'Evgeniy "aquilax" Vasilev',
		'Jakub "Student" Olek',
		'Rafał Leszczyński',
	],
	'description' => 'Create your own maps with point of interest or add your own point of interest into a real world map',
	'version' => 0.1
];

// controller classes
$wgAutoloadClasses[ 'WikiaInteractiveMapsController' ] = $dir . 'WikiaInteractiveMapsController.class.php';
$wgAutoloadClasses[ 'WikiaInteractiveMapsParserTagController' ] = $dir . 'WikiaInteractiveMapsParserTagController.class.php';

// helper classes
$wgAutoloadClasses[ 'WikiaInteractiveMapsHooks' ] = $dir . 'WikiaInteractiveMapsHooks.class.php';

// model classes
$wgAutoloadClasses[ 'WikiaMaps' ] = $dir . '/models/WikiaMaps.class.php';

// special pages
$wgSpecialPages[ 'InteractiveMaps' ] = 'WikiaInteractiveMapsController';
$wgSpecialPageGroups[ 'InteractiveMaps' ] = 'wikia';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'WikiaInteractiveMapsParserTagController::parserTagInit';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'WikiaInteractiveMapsHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'WikiaInteractiveMaps' ] = $dir . 'WikiaInteractiveMaps.i18n.php';
JSMessages::registerPackage( 'WikiaInteractiveMaps', [
	'wikia-interactive-maps-map-placeholder-error'
] );

JSMessages::registerPackage( 'WikiaInteractiveMapsCreateMap', [
	'wikia-interactive-maps-create-map-*'
] );
