<?php

class StaticUserPagesHooks {

	/**
	 * List of accounts user pages should be rendered using provided i18n strings
	 */
	const USER_PAGES_MESSAGES = [
		Wikia::USER => 'static-user-pages-user-content',
		'Fandom'    => 'static-user-pages-user-content',
		'Wikia'     => 'static-user-pages-user-content',

		Wikia::BOT_USER => 'static-user-pages-bot-content',
		'FandomBot'     => 'static-user-pages-bot-content',
		'WikiaBot'      => 'static-user-pages-bot-content',
	];

	/**
	 * Use StaticUserPagesArticle class to render selected user pages using i18n messages
	 *
	 * @param Title $title
	 * @param $article
	 * @return bool
	 */
	static public function onArticleFromTitle( Title $title, &$article ) : bool {
		if ( self::isSupportedTitle( $title ) ) {
			$article = new StaticUserPagesArticle( $title );
		}
		return true;
	}

	/**
	 * Return i18n message name for a given title (or false if there's none)
	 *
	 * @param Title $title
	 * @return string|false
	 */
	static public function getMessageForTitle( Title $title ) {
		return self::USER_PAGES_MESSAGES[ $title->getText() ] ?: false;
	}

	/**
	 * Check if given title is the one we support
	 *
	 * @param Title $title
	 * @return bool
	 */
	private static function isSupportedTitle( Title $title ) : bool {
		// not a User page, leave early
		if ( !$title->inNamespace( NS_USER ) ) {
			return false;
		}

		return in_array( $title->getText(), array_keys( self::USER_PAGES_MESSAGES ) );
	}
}
