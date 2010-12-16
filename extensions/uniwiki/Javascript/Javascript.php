<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Javascript
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Javascript',
	'author'         => array( 'Merrick Schaefer', 'Mark Johnston', 'Evan Wheeler', 'Adam Mckaig (at UNICEF)' ),
	'description'    => 'Adds uniwiki.js to each page containing Javascript code shared between Uniwiki extensions',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Javascript',
	'descriptionmsg' => 'javascript-desc',
);

$wgExtensionMessagesFiles['Javascript'] = dirname( __FILE__ ) . '/Javascript.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'UW_Javascript_addJS';
function UW_Javascript_addJS( $out ) {
	global $wgScriptPath;
	$src = "$wgScriptPath/extensions/uniwiki/Javascript/uniwiki.js";
	$out->addScript ( "<script type='text/javascript' src='$src'></script>\n" );
	return true;
}
