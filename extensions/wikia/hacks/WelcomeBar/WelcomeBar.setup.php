<?php

/**
 * Show per-wiki, customized welcome bar inspired by StackOverflow
 *
 * MW message "welcome-bar-message" allows you to customize the bar
 *
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Welcome Bar',
	'version' => '0.1',
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'welcome-bar-desc',
);

$dir = dirname(__FILE__);

$app = F::app();

// classes
$app->registerClass('WelcomeBarHooks', $dir . '/WelcomeBarHooks.class.php');

// hooks
$app->registerHook('SkinAfterBottomScripts', 'WelcomeBarHooks', 'onSkinAfterBottomScripts');

// i18n
$app->registerExtensionMessageFile('WelcomeBar', $dir . '/WelcomeBar.i18n.php');
F::build('JSMessages')->registerPackage('WelcomeBar', array(
	'welcome-bar-*',
));