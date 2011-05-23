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
		'GameGuidesWrongAPIVersionException',
		'GameGuidesRequestNotPostedException'
	),
	"{$dir}/GameGuidesController.class.php"
);

$app->registerClass( 'GameGuidesModel', "{$dir}/GameGuidesModel.class.php" );

/**
* message files
*/
$app->registerExtensionMessageFile('GameGuides', "{$dir}/GameGuides.i18n.php");