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

$dir = dirname(__FILE__) . '/';




/**
 * @var WikiaApp
 */
$app = WF::build('App');

/**
 * classes
 */
$app->registerClass('WikiaLabsSpecial', $dir . 'WikiaLabs.body.php');
$app->registerClass('WikiaLabsModule', $dir . 'WikiaLabsModule.class.php');
$app->registerClass('WikiaLabs', $dir . 'WikiaLabs.class.php');
$app->registerClass('WikiaLabsProject', $dir . 'WikiaLabsProject.class.php');


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
WF::addClassConstructor( 'WikiaLabs', array( 'app' => $app ) );
WF::addClassConstructor( 'WikiaLabsProject', array( 'app' => $app, 'id' => 0 ) );


/**
 * hooks
 */
$app->registerHook('GetRailModuleSpecialPageList', 'WikiaLabs', 'onGetRailModuleSpecialPageList' );

/*
 * ajax function
 */

$wgAjaxExportList[] = 'WikiaLabs::getProjectModal';
$wgAjaxExportList[] = 'WikiaLabs::saveProject';
$wgAjaxExportList[] = 'WikiaLabs::getUrlImageAjax';

