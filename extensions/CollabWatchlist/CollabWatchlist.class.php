<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

/** Provides hooks for the CollabWatchlist extension
 * @author fhackenberger
 */
class CollabWatchlist {
	/**
	 * Collaborative watchlist user types
	 * Defines constants for the collabwatchlistuser.rlu_type
	 */
	/** owners are allowed to edit the list */
	public static $USER_OWNER = 1;
	/** owners are allowed to edit the list */
	public static $USER_OWNER_TEXT = 'Owner';
	/** users are allowed to view the list and tag edits */
	public static $USER_USER = 2;
	/** users are allowed to view the list and tag edits */
	public static $USER_USER_TEXT = 'User';
	/** trusted editors are used to filter edits which don't require a review */
	public static $USER_TRUSTED_EDITOR = 3;
	/** trusted editors are used to filter edits which don't require a review */
	public static $USER_TRUSTED_EDITOR_TEXT = 'TrustedEditor';
	
	public static function userTypeToText( $userType ) {
		if ( $userType === CollabWatchlist::$USER_OWNER )
			return CollabWatchlist::$USER_OWNER_TEXT;
		if ( $userType === CollabWatchlist::$USER_USER )
			return CollabWatchlist::$USER_USER_TEXT;
		if ( $userType === CollabWatchlist::$USER_TRUSTED_EDITOR )
			return CollabWatchlist::$USER_TRUSTED_EDITOR_TEXT;
	}
}
