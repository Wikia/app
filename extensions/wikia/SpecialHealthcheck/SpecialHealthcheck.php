<?php
/**
 * HealthCheck
 *
 * A simple special page for server state checks,
 * requested by Artur
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-11-10
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named HealthCheck.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'HealthCheck',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'descriptionmsg' => 'healthcheck-desc'
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['HealthCheck'] = $dir . 'SpecialHealthcheck_body.php';
$wgSpecialPages['HealthCheck'] = 'HealthCheck';
