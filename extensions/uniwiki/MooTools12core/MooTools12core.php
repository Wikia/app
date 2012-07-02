<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:MooTools_1.2_Core
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'MooTools12core',
	'author'         => array( 'Merrick Schaefer', 'Mark Johnston', 'Evan Wheeler', 'Adam Mckaig (at UNICEF)' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:MooTools_1.2_Core',
	'descriptionmsg' => 'mootools12core-desc',
);

$wgExtensionMessagesFiles['MooTools12core'] = dirname( __FILE__ ) . '/MooTools12core.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'UW_MooTools12core_addJS';

function UW_MooTools12core_addJS( $out ) {
	global $wgScriptPath;
	$src = "$wgScriptPath/extensions/uniwiki/MooTools12core/mootools-1.2-core-yc.js";
	$out->addScript( "<script type='text/javascript' src='$src'></script>" );
	return true;
}
