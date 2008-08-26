<?php

#This file is part of MediaWiki.

#MediaWiki is free software: you can redistribute it and/or modify
#it under the terms of version 2 of the GNU General Public License
#as published by the Free Software Foundation.

#MediaWiki is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.

/**
 * Class to abstract management of invitations.
 *
 * @addtogroup Extensions
 */

define('INVITE_RESULT_OK', 0); // No problem
define('INVITE_RESULT_ALREADY_INVITED', 1); // The user has already been invited
define('INVITE_RESULT_NOT_ALLOWED', 2); // The inviter has not been invited
define('INVITE_RESULT_NONE_LEFT', 3); // The inviter has no invites left.
define('INVITE_RESULT_NO_SUCH_FEATURE', 4); // The feature has not been defined.
define('INVITE_RESULT_NONE_YET', 5); // The inviter has no invites yet.

class Invitations {

	/**
	 * Does this user have a valid invite to this feature?
	 * @param string $feature The feature to check.
	 * @param object $user The user to check, or null for the current user ($wgUser)
	 * @return boolean Whether or not the user has a valid invite to the feature.
	 */
	public static function hasInvite( $feature, $user = null, &$invite_age = false ) {
		global $wgUser, $wgInvitationTypes, $wgDBtype;
		if ($user === null)
			$user = $wgUser;

		// No such invitation type.
		if (!is_array($wgInvitationTypes[$feature]))
			return false;

		$dbr = wfGetDb( DB_SLAVE );

		$epoch = $wgDBtype == 'mysql' ? 'UNIX_TIMESTAMP(inv_timestamp)' :
			'EXTRACT(epoch FROM inv_timestamp)';
		$res = $dbr->select( 'invitation', "$epoch AS timestamp", array( 'inv_invitee' => $user->getId(), 'inv_type' => $feature ), __METHOD__ );

		if ($dbr->numRows($res) == 0)
			return false;

		if ($invite_age === false)
			return true;

		$row = $dbr->fetchObject($res);
		$invite_age = $row->timestamp;

		return true;
	}

	/*
	 * What features has this user been invited to?
	 * @param object $user The user to check, or null for the current user
	 * @return array Array of features the user has been invited to.
	 */
	public static function getAllowedFeatures( $user = null ) {
		global $wgUser;
		if ($user === null)
			$user = $wgUser;

		$dbr = wfGetDb( DB_SLAVE );

		$res = $dbr->select( 'invitation', array( 'inv_type' ), array( 'inv_invitee' => $user->getId() ) );

		$features = array();

		while ($row = $dbr->fetchObject( $res )) {
			$features[] = $row->inv_type;
		}

		return $features;
	}

	/**
	 * Can the given inviter invite the given invitee to the given feature?
	 * @param string $feature The feature to check.
	 * @param object $invitee The user to be invited.
	 * @param object $inviter The inviting user, or null for $wgUser.
	 * @return integer One of the INVITE_RESULT constants.
	 */
	public static function checkInviteOperation( $feature, $invitee, $inviter = null ) {
		global $wgUser, $wgInvitationTypes;

		$accountAge = 1;

		if (!is_array($wgInvitationTypes[$feature]))
			return INVITE_NO_SUCH_FEATURE;

		if ($inviter == null)
			$inviter = $wgUser;

		if (!Invitations::hasInvite($feature, $inviter, $accountAge))
			return INVITE_RESULT_NOT_ALLOWED;

		if (Invitations::hasInvite($feature, $invitee))
			return INVITE_RESULT_ALREADY_INVITED;

		$accountAge = time() - $accountAge;
		if (!Invitations::checkDelay($feature, $user, $accountAge))
			return INVITE_RESULT_NONE_YET;

		if ($wgInvitationTypes[$feature]['limitedinvites']) {
			if (Invitations::getRemainingInvites( $feature, $inviter ) == 0) {
				return INVITE_RESULT_NONE_LEFT;
			}

		}

		return INVITE_RESULT_OK;
	}

	/**
	 * How many invites does the given inviter have?
	 * @param string $feature The feature to check.
	 * @param object $user The user to check, or null for $wgUser.
	 * @return integer The number of invites left, or -1 for infinity.
	 */
	public static function getRemainingInvites( $feature, $user = null ) {
		global $wgUser, $wgInvitationTypes;
		if ($user === null)
			$user = $wgUser;

		$accountAge = 1;

		// No such invitation type.
		if (!array_key_exists($feature, $wgInvitationTypes))
			return 0;

		// Has none: not invited.
		if (!Invitations::hasInvite($feature, $user, $accountAge))
			return 0;

		$accountAge = time() - $accountAge;

		if (!$wgInvitationTypes[$feature]['limitedinvites'])
			return -1;

		if (!Invitations::checkDelay( $feature, $user, $accountAge ))
			return false;

		$dbr = wfGetDb( DB_SLAVE );

		$res = $dbr->select( 'invite_count',
			array( 'ic_count' ),
			array( 'ic_user' => $user->getId(), 'ic_type' => $feature ),
			__METHOD__ );

		if ($dbr->numRows($res) > 0) {
			$num = $dbr->fetchObject($res)->ic_count;
			return $num;
		} else {
			Invitations::insertCountRow( $feature, $user, $wgInvitationTypes[$feature]['reserve']);
			return $wgInvitationTypes[$feature]['reserve'];
		}
	}

	/**
	 * Check if the given user has had the given feature for long enough to invite.
	 * @param string $feature The feature to check
	 * @param object $user The user to check
	 * @param int $time The age of the user's account
	 */
	public static function checkDelay( $feature, $user = null, $time = null ) {
		global $wgUser, $wgInvitationTypes;
		if ($user === null)
			$user = $wgUser;

		if ($time !== null) {
			// Do nothing
		} else if ($time === null && !Invitations::hasInvite( $feature, $user, $time )) {
			return false;
		} else {
			// The user has an invite, and we retrieved its creation point. Find its age
			$time = time() - $time;
		}

		if ($time < $wgInvitationTypes[$feature]['invitedelay']) {
			return false;
		} else return true;
	}

	/**
	 * Insert a row into the invite_count table for the given user and feature.
	 * @param string $feature The feature to check.
	 * @param object $user The user to check, or null for $wgUser.
	 * @param object $count The number to insert, or NULL to insert the amount left normally.
	 * @return integer The number of invites left, or -1 for infinity.
	 */
	private static function insertCountRow( $feature, $user = null, $count = null ) {
		global $wgUser, $wgInvitationTypes;
		if ($user === null)
			$user = $wgUser;

		// No such invitation type.
		if (!is_array($wgInvitationTypes[$feature]))
			return false;

		if ($count === null)
			$count = Invitations::getRemainingInvites( $feature, $user );

		if ($count) {
			$dbw = wfGetDb( DB_MASTER );

			$dbw->replace( 'invite_count', array ('ic_user', 'ic_type'),
				array( 'ic_user' => $user->getId(), 'ic_type' => $feature, 'ic_count' => $count ),
				__METHOD__ );
		}
	}

	/**
	 * Add an invitation for the given invitee, from the given inviter.
	 * @param string $feature The feature to invite to.
	 * @param object $invitee The user to be invited.
	 * @param object $inviter The inviting user, or null for $wgUser.
	 * @return integer One of the INVITE_RESULT constants.
	 */
	public static function inviteUser( $feature, $invitee, $inviter = null ) {
		global $wgUser, $wgInvitationTypes;
		if ($inviter === null)
			$inviter = $wgUser;

		if ( ($res = Invitations::checkInviteOperation($feature, $invitee, $inviter)) != INVITE_RESULT_OK) {
			return $res;
		}

		// We /should/ be OK to go.
		$dbw = wfGetDB( DB_MASTER );

		$dbw->update( 'invite_count', array( 'ic_count=ic_count-1' ),
				array( 'ic_user' => $inviter->getId(), 'ic_type' => $feature ),
				__METHOD__ );

		$dbw->insert( 'invitation',
			array(
				'inv_invitee' => $invitee->getId(),
				'inv_inviter' => $inviter->getId(),
				'inv_type' => $feature
			),
			__METHOD__ );

		// Log it.
		$log = new LogPage( 'invite' );

		$log->addEntry( 'invite', $invitee->getUserPage(), '', array( $feature ) );

		Invitations::insertCountRow( $feature, $invitee );
	}
}
