<?php

/**
 * DisplayMessages is a simple extension that displays message keys in the UI
 * so that translators can see exactly where they go on the page, and developers
 * can debug message issues easier.
 *
 * Use ?uselang=messages on any page to see message keys.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-05-14
 * @copyright Copyright © 2011 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named DisplayMessageKeys.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
        'name' => 'DisplayMessageKeys',
        'author' => "[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	'description' => 'Allows users to see message keys in place via ?uselang=messages'
);

$wgHooks['NormalizeMessageKey'][] = 'efShowMessageKeys';

function efShowMessageKeys( &$key, &$useDB, &$langCode, &$transform ) {
	global $wgLang;

	if ( $langCode == "messages" || $wgLang->getCode() == "messages" ) {
		$key = 'message:' . $key;
	}

	return true;
}
