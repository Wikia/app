<?php

/**
 * Class for automatic rcreate of Babel category pages.
 *
 * @addtogroup Extensions
 */

class BabelAutoCreate {

	static $user = false;

	/**
	 * Abort user creation if the username is that of the autocreation username.
	 */
	public static function RegisterAbort( User $user, &$message ) {
		wfLoadExtensionMessages( 'Babel' );
		$message = wfMsg( 'babel-autocreate-abort', wfMsg( 'babel-url' ) );
		return !( $user->getName() === wfMsgForContent( 'babel-autocreate-user' ) );
	}

	/**
	 * Create category.
	 */
	public static function create( $category, $language, $level = null ) {
		$category = strip_tags($category);
		$title = Title::newFromText( $category, NS_CATEGORY );
		if( $title === null || $title->exists() ) return;
		if( $level === null ) {
			$text = wfMsgForContent( 'babel-autocreate-text-main', $language );
		} else {
			$text = wfMsgForContent( 'babel-autocreate-text-levels', $language, $level );
		}
		$article = new Article( $title );
		$article->doEdit( $text, wfMsgForContent( 'babel-autocreate-reason', wfMsgForContent( 'babel-url' ) ), EDIT_SUPPRESS_RC, false, self::user() );
	}

	/**
	 * Get user object.
	 */
	public static function user() {
		if( !self::$user ) {
			self::$user = User::newFromName( wfMsgForContent( 'babel-autocreate-user' ), false );
			if( !self::$user->isLoggedIn() ) self::$user->addToDatabase();
		}
		return self::$user;
	}

}