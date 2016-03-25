<?php

class CommunityPageSpecialHelper {

	/**
	 * Returns true if the current user has edited the current wiki
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function userHasEdited( User $user ) {
		$firstRev = ( new CommunityPageSpecialUsersModel() )->getFirstRevisionDate( $user );
		return !is_null( $firstRev );
	}
}