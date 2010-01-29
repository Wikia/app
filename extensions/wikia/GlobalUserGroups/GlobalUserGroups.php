<?php
/**
 * GlobalUserGroups
 *
 * This extension adds global groups to a user's effective group list
 * if the user has those groups assigned in the shared DB.
 *
 * Global groups are defined via an array called $wgGlobalUserGroups.
 * e.g. $wgGlobalUserGroups = array( 'staff', 'helper' );
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2010-01-29
 * @copyright Copyright © 2010 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgHooks['UserEffectiveGroups'][] = 'getGlobalUserGroups';

function getGlobalUserGroups( &$user, &$aUserGroups ) {
	wfProfileIn( __METHOD__ );

	global $wgSharedDB, $wgGlobalUserGroups;

	// only proceed if wiki is using a shared user DB
	if ( empty( $wgSharedDB ) ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	// quit early if user is not logged in
	if ( $user->isAnon() ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	// paranoia: remove any global groups present locally
	// these shouldn't be here anyway!
	$aUserGroups = array_diff( $aUserGroups, $wgGlobalUserGroups );

	$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );

	// get all user groups for current user from SharedDB
	$res = $dbr->select(
		'user_groups',
		'ug_group',
		array( 'ug_user' => $user->getId() ),
		__METHOD__
	);

	while( $row = $dbr->fetchObject( $res ) ) {
		// apply each global group
		if ( in_array( $row->ug_group, $wgGlobalUserGroups ) ) {
			$aUserGroups[] = $row->ug_group;
		}
	}

	wfProfileOut( __METHOD__ );

	return true;
}
