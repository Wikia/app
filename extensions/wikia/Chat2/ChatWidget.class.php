<?php

/**
 * @author Jacek "mech" Wozniak <mech@wikia-inc.com>
 *
 * ChatWidget object implementation
 */
class ChatWidget {

	/**
	 * TTL for chat users list. This cache is purged when a new user joins the chat, but we don't purge it when
	 * user leaves chat. That's why this cache time is pretty short
	 */
	const CHAT_USER_LIST_CACHE_TTL = 60;

	/**
	 * TTL for chat user info, this should not change too often so it's one hour
	 */
	const CHAT_USER_INFO_CACHE_TTL = 60 * 60;

	/**
	 * @brief This function set parseTag hook
	 */
	static public function onParserFirstCallInit( Parser &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( CHAT_TAG, [ __CLASS__, "parseTag" ] );
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Chat tag parser implementation
	 */
	static public function parseTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$template->set_vars( self::getTemplateVars( true ) );

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$html = $template->render( 'entryPointTag' );
		} else {
			$html = $template->render( 'entryPointTagMonobook' );
		}

		// remove newlines so parser does not try to wrap lines into paragraphs
		$html = str_replace( "\n", "", $html );

		wfProfileOut( __METHOD__ );

		return '<nowiki>' . $html . '</nowiki>';
	}

	/**
	 * @param $isEntryPoint - set to true for chat entry point embeded in the article, false for rail module
	 * Return an array of variables needed to render chat entry point template
	 *
	 * @return array
	 */
	static public function getTemplateVars( $isEntryPoint ) {
		global $wgEnableWallExt, $wgBlankImgUrl;

		return [
			'linkToSpecialChat' => SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl(),
			'isEntryPoint' => $isEntryPoint,
			'blankImgUrl' => $wgBlankImgUrl,
			'profileType' => !empty( $wgEnableWallExt ) ? 'message-wall' : 'talk-page'
		];
	}

	static public function purgeChatUsersCache() {
		WikiaDataAccess::cachePurge( self::getChatUsersMemcKey() );
	}

	static private function getChatUsersMemcKey() {
		return wfMemcKey( 'chatusersinfo' );
	}

	/**
	 * Return information about users present in the chat channel. This method has its internal cache. Method returns
	 * an array, where each of the users is described by the following attributes:
	 * * username - chatter login
	 * * avatarUrl - chatter avatar url
	 * * editCount - number of chatter's edits
	 * * showSince - flag indicating if we can display the information when the chatter joined the wiki
	 * * since_year && since_month - month and year, when chatter joined this wiki
	 * * profileUrl - link to chatter talk page (or message wall, if it's enabled)
	 * * contribsUrl - link to chatter contribution page
	 * @return array array containing chatters info
	 */
	static public function getChatUsersInfo() {
		global $wgReadOnly;
		wfProfileIn( __METHOD__ );

		Chat::info( __METHOD__ . ': Method called' );
		$chatters = [ ];
		if ( empty( $wgReadOnly ) ) {
			// cache the whole response
			// individual users are cached anyway, but still we gain performance making just one memcache request instead of several
			$chatters = WikiaDataAccess::cache(
				self::getChatUsersMemcKey(),
				ChatWidget::CHAT_USER_LIST_CACHE_TTL,
				function () {
					return array_map(
						[ __CLASS__, 'getUserInfo' ],
						Chat::getChatters() );
				} );
		}
		wfProfileOut( __METHOD__ );

		return $chatters;
	}

	/**
	 * Get user info needed to render chat avatar
	 *
	 * @param string $userName
	 * @return array
	 */
	static public function getUserInfo( $userName ) {
		return WikiaDataAccess::cache(
			wfMemcKey( 'chatavatars', $userName, 'v2' ),
			self::CHAT_USER_INFO_CACHE_TTL,
			function () use ( $userName ) {
				global $wgEnableWallExt;
				$chatter = [
					'username' => $userName,
					'avatarUrl' => AvatarService::getAvatarUrl( $userName, ChatRailController::AVATAR_SIZE )
				];

				// get stats for edit count and member since
				$user = User::newFromName( $userName );
				if ( $user instanceof User ) {
					$userStatsService = new UserStatsService( $user->getId() );
					$stats = $userStatsService->getStats();

					// edit count
					$chatter['editCount'] = $stats['edits'];

					// member since
					$chatter['showSince'] = $chatter['editCount'] != 0;
					if ( $chatter['showSince'] ) {
						$date = getdate( strtotime( $stats['date'] ) );
						$chatter['since_year'] = $date['year'];
						$chatter['since_month'] = $date['mon'];
					}

					if ( !empty( $wgEnableWallExt ) ) {
						$chatter['profileUrl'] = Title::makeTitle( NS_USER_WALL, $chatter['username'] )->getFullURL();
					} else {
						$chatter['profileUrl'] = Title::makeTitle( NS_USER_TALK, $chatter['username'] )->getFullURL();
					}

					$chatter['contribsUrl'] = SpecialPage::getTitleFor( 'Contributions', $chatter['username'] )->getFullURL();
				}

				return $chatter;
			} );
	}
}
