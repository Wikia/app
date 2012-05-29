<?php
/**
 * UserLogin
 *
 * @author Hyun Lim, Kyle Florence
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStyleGuide',
);
 
$dir = dirname(__FILE__) . '/';
$app = F::app();

// classes
$app->registerClass('WikiaStyleGuideSpecialController', $dir . 'WikiaStyleGuideSpecialController.class.php');

// special pages
$app->registerSpecialPage('WikiaStyleGuide', 'WikiaStyleGuideSpecialController');

// i18n
$app->registerExtensionMessageFile('WikiaStyleGuide', $dir.'WikiaStyleGuide.i18n.php');