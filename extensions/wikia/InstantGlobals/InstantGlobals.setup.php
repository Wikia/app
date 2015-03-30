<?php

/**
 * This extension emits WikiFactory variables as JS globals.
 *
 * Variables are exposed via ResourceLoader module with a short CDN caching time, allowing us to make critial config
 * changes with no need to wait 24h for CDN cache to invalidate.
 *
 * - InstantGlobalsModule::$variables contains the list of WF variables to be emitted by the module
 * - variables values are taken from Community Wiki
 * - caching time on both server and client-side is 300 sec
 * - RL module is only loaded in Oasis
 * - values are available in Wikia.InstantGlobals object
 *
 * @author macbre
 */

/**
 * info
 */
$wgExtensionCredits['other'][] = [
	'name' => 'InstantGlobals',
	'author' => 'Maciej Brencz',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InstantGlobals',
	'descriptionmsg' => 'instantglobals-desc'
];

/**
 * classes
 */
$dir = __DIR__;

$wgAutoloadClasses['InstantGlobalsHooks'] = "{$dir}/InstantGlobalsHooks.class.php";
$wgAutoloadClasses['InstantGlobalsModule'] = "{$dir}/InstantGlobalsModule.class.php";

// i18n
$wgExtensionMessagesFiles['InstantGlobals'] = $dir . '/InstantGlobals.i18n.php';

/**
 * hooks
 */
$wgHooks['WikiaSkinTopShortTTLModules'][] =  'InstantGlobalsHooks::onWikiaSkinTopShortTTLModules';

/**
 * register Resource Loader module
 */
$wgResourceModules['wikia.ext.instantGlobals'] = [
	'class' => 'InstantGlobalsModule',
];

/**
 * Register Resource Loader module for querystring-based
 * overriding tool for InstantGlobals
 */
$wgResourceModules['wikia.ext.instantGlobalsOverride'] = [
	'scripts' => "extensions/wikia/InstantGlobals/js/instantGlobalsOverride.js",
	'source'  => 'common',
];
