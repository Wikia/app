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
$app->registerClass('WikiFeaturesSpecialController', $dir . 'WikiFeaturesSpecialController.class.php');
$app->registerClass('WikiFeaturesHelper', $dir . 'WikiFeaturesHelper.class.php');
$app->registerClass('WikiaLabsSpecialController', $dir . 'WikiaLabsSpecialController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiFeatures'] = $dir . 'WikiFeatures.i18n.php';

// special pages
$app->registerSpecialPage('WikiFeatures', 'WikiFeaturesSpecialController');
$app->registerSpecialPage('WikiaLabs', 'WikiaLabsSpecialController');

$wgAvailableRights[] = 'wikifeatures';

$wgGroupPermissions['*']['wikifeatures'] = false;
$wgGroupPermissions['staff']['wikifeatures'] = true;
$wgGroupPermissions['sysop']['wikifeatures'] = true;
$wgGroupPermissions['bureaucrat']['wikifeatures'] = true;
