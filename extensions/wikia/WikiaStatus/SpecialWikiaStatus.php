<?php
/**
 * WikiaStatus
 *
 * This extension is used by Wikia Staff to easily extract important status information,
 * mainly for external monitoring (Nagios, etc.).
 *
 * IMPORTANT NOTE: DO NOT TRANSLATE ANYTHING IN THIS EXTENSION.
 * Scripts reading it look for specific English text. Thank you. 
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-10-26
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WikiaStatus.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStatus',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'description' => 'Shows various status information used by Wikia Staff'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['WikiaStatus'] = $dir. 'SpecialWikiaStatus_body.php';
$wgSpecialPages['WikiaStatus'] = 'WikiaStatus';
