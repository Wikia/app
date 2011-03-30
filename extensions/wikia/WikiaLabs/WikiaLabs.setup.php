<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
	exit( 1 );
}


$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaLabs',
	'author' => "Tomasz Odrobny Adrain 'ADi' Wieczorek",
	'url' => '',
	'description' => '',
	'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.0',
);

$wgExtensionFunctions[] = 'WikiaLabsSetup';

function WikiaLabsSetup() {
	$dir = dirname(__FILE__) . '/';

	/**
	 * @var WikiaApp
	 */
	$app = F::app();

	/**
	 * classes
	 */
	$app->registerClass('WikiaLabsSpecial', $dir . 'WikiaLabsSpecial.class.php');
	$app->registerClass('WikiaLabsModule', $dir . 'WikiaLabsModule.class.php');
	$app->registerClass('WikiaLabs', $dir . 'WikiaLabs.class.php');
	$app->registerClass('WikiaLabsProject', $dir . 'WikiaLabsProject.class.php');
	$app->registerClass('WikiaLabsHelper', $dir . 'WikiaLabsHelper.class.php');

	/**
	 * special pages
	 */
	$app->registerSpecialPage('WikiaLabs', 'WikiaLabsSpecial');

	/**
	* message files
	*/
	$app->registerExtensionMessageFile('WikiaLabs', $dir . 'WikiaLabs.i18n.php' );

	/**
	 * alias files
	 */
	$app->registerExtensionAliasFile('WikiaLabs', $dir . 'WikiaLabs.alias.php');

	/**
	 * Factory config
	 */
	F::addClassConstructor( 'WikiaLabs', array( 'app' => $app ) );
	F::addClassConstructor( 'WikiaLabsProject', array( 'app' => $app, 'id' => 0 ) );

	/**
	 * hooks
	 */
	$app->registerHook('GetRailModuleSpecialPageList', 'WikiaLabs', 'onGetRailModuleSpecialPageList' );
	$app->registerHook('MyTools::getDefaultTools', 'WikiaLabs', 'onGetDefaultTools' );

	/*
	 * set global 
	*/
	$logTypes = $app->getGlobal('wgLogTypes');
	$logTypes[] = 'wikialabs';
	$app->setGlobal('wgLogTypes', $logTypes);

	$logHeaders = $app->getGlobal('wgLogHeaders');
	$logHeaders['wikialabs'] = 'wikialabs';
	$app->setGlobal('wgLogHeaders', $logHeaders);
}

/*
 * ajax function
 */
$wgAjaxExportList[] = 'WikiaLabsHelper::getProjectModal';
$wgAjaxExportList[] = 'WikiaLabsHelper::saveProject';
$wgAjaxExportList[] = 'WikiaLabsHelper::getImageUrlForEdit';
$wgAjaxExportList[] = 'WikiaLabsHelper::switchProject';
$wgAjaxExportList[] = 'WikiaLabsHelper::saveFeedback';
