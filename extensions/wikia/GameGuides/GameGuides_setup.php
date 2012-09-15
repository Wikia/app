<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
$dir = dirname( __FILE__ );
$app = F::app();

/**
 * classes
 */
$app->registerClass(
	array(
		'GameGuidesController',
		'GameGuidesWrongAPIVersionException'
	),
	"{$dir}/GameGuidesController.class.php"
);

$app->registerClass( 'GameGuidesModel', "{$dir}/GameGuidesModel.class.php" );


//Special Page to preview page in GameGuide style
$app->registerClass( 'GameGuidesSpecialController', "{$dir}/GameGuidesSpecialController.class.php" );
$app->registerSpecialPage('GameGuidesPreview', 'GameGuidesSpecialController');


/**
* message files
*/
$app->registerExtensionMessageFile('GameGuides', "{$dir}/GameGuides.i18n.php");

$wgGroupPermissions['*']['gameguidespreview'] = false;
$wgGroupPermissions['staff']['gameguidespreview'] = true;
$wgGroupPermissions['sysop']['gameguidespreview'] = true;