<?php

/**
 * ContentWarning
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ContentWarning',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' )
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['ContentWarningController'] =  $dir.'ContentWarningController.class.php';
$wgAutoloadClasses['ContentWarningHooks'] =  $dir . 'ContentWarningHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['ContentWarning'] = $dir.'ContentWarning.i18n.php';

// Hooks
$wgHooks['GetHTMLAfterBody'][] = 'ContentWarningHooks::onGetHTMLAfterBody';
$wgHooks['BeforePageDisplay'][] = 'ContentWarningHooks::onBeforePageDisplay';
