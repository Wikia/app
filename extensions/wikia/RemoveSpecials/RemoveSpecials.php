<?php
/**
 * RemoveSpecials
 *
 * Removes special pages from the wiki based on a list in
 * $wgDisabledSpecialPages
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-09-02
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named EditAccount.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'RemoveSpecials',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'description' => 'Disables specified core special pages.'
);

$wgHooks['SpecialPage_initList'][] = 'efRemoveSpecialPages';

function efRemoveSpecialPages ( &$list ) {
	global $wgDisabledSpecialPages;

	if ( empty( $wgDisabledSpecialPages ) ) {
		return true;
	}

	foreach ( $wgDisabledSpecialPages as $page ) {
		unset( $list[$page] );
	}

	return true;
}
