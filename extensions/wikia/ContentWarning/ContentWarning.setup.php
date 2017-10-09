<?php

/**
 * ContentWarning
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ContentWarning',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ContentWarning',
	'descriptionmsg' => 'content-warning-desc',
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['ContentWarningController'] =  $dir . 'ContentWarningController.class.php';
$wgAutoloadClasses['ContentWarningHooks'] =  $dir . 'ContentWarningHooks.class.php';

// i18n mapping

// Hooks
$wgHooks['GetHTMLAfterBody'][] = 'ContentWarningHooks::onGetHTMLAfterBody';
$wgHooks['BeforePageDisplay'][] = 'ContentWarningHooks::onBeforePageDisplay';
