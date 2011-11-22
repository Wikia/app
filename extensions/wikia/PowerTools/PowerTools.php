<?php
/**
 * PowerTools
 *
 * This extension enables users with access rights to delete and protect articles in one
 * action (and potentially perform other power-user actions easier in the future).
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-11-22
 * @copyright Copyright © 2011 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named PowerTools.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
        'name' => 'PowerTools',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
        'description' => 'Enables privilidged users to delete and protect pages in one action.'
);

// New user right, required to use the extension.
$wgAvailableRights[] = 'powerdelete';
$wgGroupPermissions['*']['powerdelete'] = false;

$wgAutoloadClasses['PowerTools'] = dirname( __FILE__ ) . '/PowerTools.class.php';

$wgHooks['UnknownAction'][] = 'PowerTools::onPowerDelete';
