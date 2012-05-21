<?php

/**
 * ContentWarning
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ContentWarning',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass('ContentWarningSpecialController', $dir . 'ContentWarningSpecialController.class.php');

// i18n mapping
$app->registerExtensionMessageFile('ContentWarning', $dir.'ContentWarning.i18n.php');

// special pages
$app->registerSpecialPage('ContentWarning', 'ContentWarningSpecialController');
