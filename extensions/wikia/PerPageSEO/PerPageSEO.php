<?php

/**
 * PerPageSEO
 *
 * This is an extension that replaces default keywords and description based on
 * a per-page list of definitions stored in two arrays. No magic here.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-04-13
 * @copyright Copyright © 2011 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named PerPageSEO.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'PerPageSEO',
        'version' => '1.0',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
);

$wgHooks['BeforePageDisplay'][] = 'efPerPageSEO';

$wgPPSEOCustomKeywords = array();
$wgPPSEOCustomDescriptions = array();

function efPerPageSEO( $out ) {
	global $wgTitle, $wgPPSEOCustomKeywords, $wgPPSEOCustomDescriptions;

	$pagename = $wgTitle->getPrefixedText();

	if ( !empty( $wgPPSEOCustomKeywords[$pagename] ) ) {
		$out->mKeywords = explode( ',', $wgPPSEOCustomKeywords[$pagename] );
	}

	if ( isset( $wgPPSEOCustomDescriptions[$pagename] ) ) {
		$out->addMeta( 'description', $wgPPSEOCustomDescriptions[$pagename] );
	}

	return true;
}
