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
	const RIGHT_RAIL_MODULE_CLASS = 'module';
	const PARSER_TAG_CLASS = 'ChatWidget';

	/**
	 * TTL for chat user info, this should not change too often so it's one hour
	 */
	const CHAT_USER_INFO_CACHE_TTL = 3600;

	/**
	 * @brief This function set parseTag hook
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( CHAT_TAG, [ __CLASS__, "parseTag" ] );
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Return an array of variables needed to render chat entry point mustache template
	 *
	 * @param $fromParserTag - set to true for chat entry point embedded in the article,
	 * set to false for rail module
	 *
	 * @return array
	 */
	public static function getTemplateVars( $fromParserTag ) {
		global $wgEnableWallExt, $wgBlankImgUrl, $wgUser, $wgSitename;

		$guidelinesText = wfMessage( 'chat-entry-point-guidelines' );
		$joinChatMessage = wfMessage( 'chat-join-the-chat' );
		$usersInfo = $wgUser->isLoggedIn() ? ChatWidget::getUsersInfo() : [];
		$usersCount = count( $usersInfo );
		$myAvatarUrl = AvatarService::getAvatarUrl( $wgUser->getName(), ChatRailController::AVATAR_SIZE );
		$buttonMessage = $usersCount ? 'chat-join-the-chat' : 'chat-start-a-chat';

		$vars = [
			'blankImgUrl' => $wgBlankImgUrl,
			'buttonText' => wfMessage($buttonMessage)->text(),
			'guidelinesText' => $guidelinesText->exists() ? $guidelinesText->parse() : null,
			'fromParserTag' => $fromParserTag,
			'joinChatText' => $joinChatMessage->exists() ? $joinChatMessage->text() : null,
			'linkToSpecialChat' => SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl(),
			'profileType' => empty( $wgEnableWallExt ) ? 'talk-page' : 'message-wall',
			'sectionClassName' => $fromParserTag ? self::PARSER_TAG_CLASS : self::RIGHT_RAIL_MODULE_CLASS,
			'siteName' => $wgSitename,
			'userName' => $wgUser->isLoggedIn() ? $wgUser->getName() : null,
			'users' => $usersInfo,
			'hasUsers' => $usersCount > 0,
			'usersCount' => $usersCount,
		];

		if ( $usersCount == 0 && $wgUser->isLoggedIn() ) {
			$vars['myAvatarUrl'] = $myAvatarUrl;
		}

		return $vars;
	}

	/**
	 * Chat tag parser implementation.
	 * Return html of a chat wrapped in nowiki tags.
	 */
	public static function parseTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( __DIR__ . '/templates' );

		$html = $templateEngine->clearData()
			->setData( self::getTemplateVars( true ) )
			->render( self::getTemplateName() );

		// remove newlines so parser does not try to wrap lines into paragraphs
		$html = str_replace( "\n", "", $html );

		wfProfileOut( __METHOD__ );

		return '<nowiki>' . $html . '</nowiki>';
	}

	/**
	 * Return proper template name according to current skin
	 *
	 * @return string template name to render
	 */
	public static function getTemplateName() {

		return F::app()->checkSkin( 'oasis' ) ?
			'widget.mustache' :
			'widgetMonobook.mustache';
	}

	public static function purgeChatUsersCache() {
		WikiaDataAccess::cachePurge( self::getUsersInfoMemcKey() );
	}

	/**
	 * Return information about users present in the chat channel. This method has its internal cache. Method returns
	 * an array, where each of the users is described by the following attributes:
	 * * username - chatter login
	 * * avatarUrl - chatter avatar url
	 * * editCount - number of chatter's edits
	 * * showSince - flag indicating if we can display the information when the chatter joined the wiki
	 * * since_year && since_month - month and year, when chatter joined this wiki
	 * * since - since year and month in the form of string "MMM YYYY". Months are in wgLang and abbreviated
	 * * profileUrl - link to chatter talk page (or message wall, if it's enabled)
	 * * contribsUrl - link to chatter contribution page
	 * @return array array containing chatters info
	 */
	public static function getUsersInfo() {
		global $wgReadOnly;

		wfProfileIn( __METHOD__ );

		Chat::info( __METHOD__ . ': Method called' );
		$chatters = [ ];
		if ( empty( $wgReadOnly ) ) {
			// cache the whole response
			// individual users are cached anyway, but still we gain performance making just one memcache request instead of several
			$chatters = WikiaDataAccess::cache(
				self::getUsersInfoMemcKey(),
				ChatWidget::CHAT_USER_LIST_CACHE_TTL,
				function () {
					return array_map( function ( $userName ) {
						return self::getUserInfo( $userName );
					}, Chat::getChatters() );
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
	public static function getUserInfo( $userName ) {
		return WikiaDataAccess::cache(
			self::getUserInfoMemcKey( $userName ),
			self::CHAT_USER_INFO_CACHE_TTL,
			function () use ( $userName ) {
				global $wgEnableWallExt, $wgLang;

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
						$months = $wgLang->getMonthAbbreviationsArray();
						$date = getdate( strtotime( $stats['date'] ) );

						$chatter['since_year'] = $date['year'];
						$chatter['since_month'] = $date['mon'];
						$chatter['since'] = sprintf( '%s %s', $months[$chatter['since_month']], $chatter['since_year'] );
					}

					$profileUrlNs = !empty( $wgEnableWallExt ) ? NS_USER_WALL : NS_USER_TALK;
					$chatter['profileUrl'] = Title::makeTitle( $profileUrlNs, $chatter['username'] )->getFullURL();
					$chatter['contribsUrl'] = SpecialPage::getTitleFor( 'Contributions', $chatter['username'] )->getFullURL();
				}

				return $chatter;
			} );
	}

	private static function getUsersInfoMemcKey() {
		return wfMemcKey( 'chatusersinfo' );
	}

	private static function getUserInfoMemcKey( $userName ) {
		return wfMemcKey( 'chatavatars', $userName, 'v2' );
	}
}
