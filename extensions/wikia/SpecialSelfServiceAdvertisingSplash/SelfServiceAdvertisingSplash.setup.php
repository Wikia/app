<?php

/**
 * SelfServiceAdvertisingSplash
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
	'name' => 'SelfServiceAdvertisingSplash',
	'author' => 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'description' => 'Self Service Advertising Splash Page',
	'version' => 1.0
);

//classes
$app->registerClass('SelfServiceAdvertisingSplashController', $dir . 'SelfServiceAdvertisingSplashController.php');
$app->registerClass('SelfServiceAdvertisingSplashModel', $dir . 'SelfServiceAdvertisingSplashModel.php');

//special page
$app->registerSpecialPage('SelfServiceAdvertisingSplash', 'SelfServiceAdvertisingSplashController');

//i18n mapping
$app->registerExtensionMessageFile('SelfServiceAdvertisingSplash', $dir . 'SelfServiceAdvertisingSplash.i18n.php');

F::build('JSMessages')->registerPackage('SelfServiceAdvertisingSplash', array(
  'ssa-splash-modal-*',
));
