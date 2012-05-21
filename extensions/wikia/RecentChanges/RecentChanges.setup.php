<?php

/**
 * RecentChanges
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'RecentChanges',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass('RecentChangesSpecialController', $dir . 'RecentChangesSpecialController.class.php');

// i18n mapping
$app->registerExtensionMessageFile('RecentChanges', $dir.'RecentChanges.i18n.php');

// special pages
$app->registerSpecialPage('RecentChanges', 'RecentChangesSpecialController');
