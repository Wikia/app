<?php
/**
 * This is a small helper extension that will include yui.js on every pageload
 * as SocialProfile relies on YUI functions.
 *
 * @file
 * @ingroup Extensions
 */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'Yahoo! User Interface Library',
	'author' => 'Yahoo! Inc.',
	'version' => '2.7.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A set of utilities and controls, written in JavaScript',
	'descriptionmsg' => 'yui-desc',
);

// Internationalization
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['YUI'] = $dir . 'yui.i18n.php';

$wgExtensionFunctions[] = 'wfYUI';

/**
 * Adds yui.js into the <head> element of each and every page
 */
function wfYUI() {
	global $wgOut, $wgScriptPath;
	$wgOut->addScriptFile( $wgScriptPath . '/extensions/SocialProfile/YUI/yui.js' );
}
