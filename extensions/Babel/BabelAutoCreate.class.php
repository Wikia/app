<?php
/**
 * Class for automatic rcreate of Babel category pages.
 *
 * @ingroup Extensions
 */
class BabelAutoCreate {

	/**
	 * @var User
	 */
	static $user = false;

	/**
	 * Abort user creation if the username is that of the autocreation username.
	 * @param $user User
	 * @param $message
	 * @return bool
	 */
	public static function RegisterAbort( User $user, &$message ) {
		$message = wfMsg( 'babel-autocreate-abort', wfMsg( 'babel-url' ) );
		return $user->getName() !== wfMsgForContent( 'babel-autocreate-user' );
	}

	/**
	 * Create category.
	 *
	 * @param $category String: Name of category to create.
	 * @param $code String: Code of language that the category is for.
	 * @param $level String: Level that the category is for.
	 */
	public static function create( $category, $code, $level = null ) {
		$category = strip_tags( $category );
		$title = Title::makeTitleSafe( NS_CATEGORY, $category );
		if ( $title === null || $title->exists() ) {
			return;
		}
		global $wgLanguageCode;
		$language = BabelLanguageCodes::getName( $code, $wgLanguageCode );
		if ( $level === null ) {
			$text = wfMsgForContent( 'babel-autocreate-text-main', $language, $code );
		} else {
			$text = wfMsgForContent( 'babel-autocreate-text-levels', $level, $language, $code );
		}

		$user = self::user();
		# Do not add a message if the username is invalid or if the account that adds it, is blocked
		if ( !$user || $user->isBlocked() ) {
			return;
		}

		if( !$title->quickUserCan( 'create', $user ) ) {
			return; # The Babel AutoCreate account is not allowed to create the page
		}

		/* $article->doEdit will call $wgParser->parse.
		 * Calling Parser::parse recursively is baaaadd... (bug 29245)
		 * @todo FIXME: surely there is a better way?
		 */
		global $wgParser, $wgParserConf;
		$oldParser = $wgParser;
		$parserClass = $wgParserConf['class'];
		$wgParser = new $parserClass( $wgParserConf );

		$article = new Article( $title, 0 );
		$article->doEdit(
			$text,
			wfMsgForContent( 'babel-autocreate-reason', wfMsgForContent( 'babel-url' ) ),
			EDIT_FORCE_BOT,
			false,
			$user
		);

		$wgParser = $oldParser;
	}

	/**
	 * Get user object.
	 *
	 * @return User object: User object for autocreate user.
	 */
	public static function user() {
		if ( !self::$user ) {
			self::$user = User::newFromName( wfMsgForContent( 'babel-autocreate-user' ) );
			if ( self::$user && !self::$user->isLoggedIn() ) {
				self::$user->addToDatabase();
			}
		}
		return self::$user;
	}
}
