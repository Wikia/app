<?php
/**
 * WikiFeatures
 *
 * @author Hyun Lim, Owen Davis
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerController(
	'WikiFeaturesSpecialController',
	$dir . 'WikiFeaturesSpecialController.class.php',
	array( 'index' => array( "skin" => array( "monobook", "wikiamobile" ), "method" => "notOasis") )
);

$app->registerClass('WikiFeaturesHelper', $dir . 'WikiFeaturesHelper.class.php');
$app->registerClass('WikiaLabsSpecialController', $dir . 'WikiaLabsSpecialController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiFeatures'] = $dir . 'WikiFeatures.i18n.php';
$wgExtensionMessagesFiles['WikiFeaturesAliases'] = $dir . 'WikiFeatures.alias.php' ;

// special pages
$app->registerSpecialPage('WikiFeatures', 'WikiFeaturesSpecialController');
$app->registerSpecialPage('WikiaLabs', 'WikiaLabsSpecialController');

$wgAvailableRights[] = 'wikifeatures';

$wgGroupPermissions['*']['wikifeatures'] = false;
$wgGroupPermissions['staff']['wikifeatures'] = true;
$wgGroupPermissions['sysop']['wikifeatures'] = true;
$wgGroupPermissions['bureaucrat']['wikifeatures'] = true;
$wgGroupPermissions['helper']['wikifeatures'] = true;

$wgGroupPermissions['*']['wikifeaturesview'] = false;
$wgGroupPermissions['user']['wikifeaturesview'] = true;

$wgLogTypes[] = 'wikifeatures';
$wgLogNames['wikifeatures'] = 'wikifeatures-log-name';
$wgLogHeaders['wikifeatures'] = 'wikifeatures-log-header';
