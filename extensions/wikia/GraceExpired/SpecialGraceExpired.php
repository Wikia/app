<?php
/**
 * GraceExpired
 *
 * This extension was written for pvx.wikia.com, based on their old version,
 * and is used to display pages in the Build namespace (custom) that are classified
 * as trash, trial etc. and have not been editied for over 2 weeks and so should be
 * deleted. 
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-04-08
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named GraceExpired.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'GraceExpired',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
        'description' => 'Lists builds marked as trash, trial, etc. that have not been edited for over 2 weeks'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Graceexpired'] = $dir . 'SpecialGraceExpired.i18n.php';
$wgAutoloadClasses['GraceExpiredSpecialPage'] = $dir . 'SpecialGraceExpired_body.php';
$wgSpecialPages['GraceExpired'] = 'GraceExpiredSpecialPage';
// Special page group for MW 1.13+
$wgSpecialPageGroups['GraceExpiredSpecialPage'] = 'maintenance';
