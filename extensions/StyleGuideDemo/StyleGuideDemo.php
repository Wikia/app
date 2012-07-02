<?php
/**
 * Style guide demonstration extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * Dual-licensed
 * @license Creative Commons Attribution 3.0 Unported license
 * @license GPL v2 or later
 * @author Timo Tijhof <krinklemail@gmail.com>
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Style guide demonstration',
	'author' => array(
		'Timo Tijhof',
	),
	'version' => '0.1.0',
	'descriptionmsg' => 'styleguidedemo-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:StyleGuideDemo'
);

// Autoloading
$dir = dirname( __FILE__ ) . '/';
// @todo Integrate HTMLStyleForm into core HTMLForm or come up with a better name
$wgAutoloadClasses['HTMLStyleForm'] = $dir . 'HTMLStyleForm.php';
$wgAutoloadClasses['SpecialStyleGuideDemo'] = $dir . 'SpecialStyleGuideDemo.php';
$wgExtensionMessagesFiles['StyleGuideDemo'] = $dir . 'StyleGuideDemo.i18n.php';
$wgExtensionMessagesFiles['StyleGuideDemoAlias'] = $dir . 'StyleGuideDemo.alias.php';

// Special Page
$wgSpecialPages['StyleGuideDemo'] = 'SpecialStyleGuideDemo';
$wgSpecialPageGroups['StyleGuideDemo'] = 'other';

// Modules
$wgResourceModules['ext.styleguidedemo.css'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules/ext.styleguidedemo',
	'remoteExtPath' => 'StyleGuideDemo/modules/ext.styleguidedemo',
	'styles' => 'ext.styleguidedemo.css',
	'position' => 'top',
);
$wgResourceModules['ext.styleguidedemo.js'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules/ext.styleguidedemo',
	'remoteExtPath' => 'StyleGuideDemo/modules/ext.styleguidedemo',
	'scripts' => 'ext.styleguidedemo.js',
	'messages' => array(),
	'position' => 'top',
);

