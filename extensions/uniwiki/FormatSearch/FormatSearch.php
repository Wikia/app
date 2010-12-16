<?php
/* vim: noet ts=4 sw=4
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( "MEDIAWIKI" ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'FormatSearch',
	'author'         => array( 'Merrick Schaefer', 'Mark Johnston', 'Evan Wheeler', 'Adam Mckaig (at UNICEF)' ),
	'description'    => 'Changes to clean up the search results page',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Format_Search',
	'descriptionmsg' => 'formatsearch-desc',
);

$wgExtensionMessagesFiles['FormatSearch'] = dirname( __FILE__ ) . '/FormatSearch.i18n.php';

/* ---- HOOKS ---- */
$wgHooks['BeforePageDisplay'][] = "UW_FormatSearch_CSS";

function UW_FormatSearch_CSS ( &$out ) {
	global $wgScriptPath;
	$href = "$wgScriptPath/extensions/uniwiki/FormatSearch/style.css";
	$out->addScript ( "<link rel='stylesheet' href='$href' />" );
	return true;
}
