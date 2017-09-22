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
	const RIGHT_RAIL_MODULE_CLASS = 'rail-module';
	const PARSER_TAG_CLASS = 'ChatWidget';
	const CHAT_AVATARS_LIMIT = 5;

	/**
	 * TTL for chat user info, this should not change too often so it's one hour
	 */
	const CHAT_USER_INFO_CACHE_TTL = 3600;

	/**
	 * @brief This function set parseTag hook
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ): bool {
		$parser->setHook( CHAT_TAG, [ __CLASS__, "parseTag" ] );

		return true;
	}

	public static function getViewedUsersInfo($usersInfo) {
		global $wgUser;

		if(!empty($usersInfo)) {
			return array_slice( $usersInfo, 0, self::CHAT_AVATARS_LIMIT );
		}
		$myAvatarUrl =
			AvatarService::getAvatarUrl( $wgUser->getName(), ChatRailController::AVATAR_SIZE );
		return [
			[
				'username' => User::isIp( $wgUser->getName() )
					? wfMessage( 'oasis-anon-user' )->escaped() : $wgUser->getName(),
				'profileUrl' => $wgUser->getUserPage()->getLinkURL(),
				'avatarUrl' => $myAvatarUrl,
			],
		];
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
		$viewedUsersInfo = self::getViewedUsersInfo( $usersInfo );
		$usersCount = count( $usersInfo );
		$buttonMessage = $usersCount ? 'chat-join-the-chat' : 'chat-start-a-chat';

		return [
			'blankImgUrl' => $wgBlankImgUrl,
			'buttonText' => wfMessage( $buttonMessage )->text(),
			'chatLiveText' => wfMessage( 'chat-live2' )->text(),
			'buttonIcon' => DesignSystemHelper::renderSvg( 'wds-icons-reply-tiny' ),
			'guidelinesText' => $guidelinesText->exists() ? $guidelinesText->parse() : null,
			'fromParserTag' => $fromParserTag,
			'joinChatText' => $joinChatMessage->exists() ? $joinChatMessage->text() : null,
			'linkToSpecialChat' => SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl(),
			'profileType' => empty( $wgEnableWallExt ) ? 'talk-page' : 'message-wall',
			'sectionClassName' => $fromParserTag ? self::PARSER_TAG_CLASS
				: self::RIGHT_RAIL_MODULE_CLASS,
			'siteName' => $wgSitename,
			'userName' => $wgUser->isLoggedIn() ? $wgUser->getName() : null,
			'viewedUsersInfo' => $viewedUsersInfo,
			'hasUsers' => $usersCount > 0,
			'moreUsersCount' => $usersCount - self::CHAT_AVATARS_LIMIT > 0 ? $usersCount - self::CHAT_AVATARS_LIMIT : null,
		];
	}

	/**
	 * Chat tag parser implementation.
	 *
	 * @param string $input tag contents - unused
	 * @param array $args tag attributes - unused
	 * @param Parser $parser MW parser instance
	 * @return string parsed widget HTML wrapped in <nowiki> tags
	 */
	public static function parseTag( $input, array $args, Parser $parser ) {
		wfProfileIn( __METHOD__ );

		$templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( __DIR__ . '/templates' );

		$html = $templateEngine->clearData()
			->setData( self::getTemplateVars( true ) )
			->render( self::getTemplateName() );

		// remove newlines so parser does not try to wrap lines into paragraphs
		$html = str_replace( "\n", "", $html );

		// SUS-749: Add required MW messages to output
		$parser->getOutput()->addModuleMessages( 'ext.Chat2.ChatWidget' );

		wfProfileOut( __METHOD__ );
		return $html;
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
	 * * since - since year and month in the form of string "MMM YYYY". Months are in wgLang and abbreviated
	 * * profileUrl - link to chatter talk page (or message wall, if it's enabled)
	 * * contribsUrl - link to chatter contribution page
	 * @return array array containing chatters info
	 */
	public static function getUsersInfo() {
		global $wgReadOnly;

		wfProfileIn( __METHOD__ );

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
				/* @var Language $wgLang */
				global $wgEnableWallExt, $wgLang;

				$chatter = [
					'username' => $userName,
					'avatarUrl' => AvatarService::getAvatarUrl( $userName, ChatRailController::AVATAR_SIZE )
				];

				// get stats for edit count and member since
				$user = User::newFromName( $userName );

				if ( $user instanceof User && !$user->isAnon() ) {
					$userStatsService = new UserStatsService( $user->getId() );
					$stats = $userStatsService->getStats();

					// edit count
					$chatter['editCount'] = $stats['editcount'];

					// member since
					$months = $wgLang->getMonthAbbreviationsArray();

					// SUS-1994 - fallback to user registration date if he has no contributions yet
					$date = getdate( strtotime( $stats['firstContributionTimestamp'] ?: $user->getRegistration() ) );
					$chatter['since'] = sprintf( '%s %s', $months[$date['mon']], $date['year'] );

					$profileUrlNs = !empty( $wgEnableWallExt ) ? NS_USER_WALL : NS_USER_TALK;
					$chatter['profileUrl'] = Title::makeTitle( $profileUrlNs, $chatter['username'] )->getFullURL();
					$chatter['contribsUrl'] = SpecialPage::getTitleFor( 'Contributions', $chatter['username'] )->getFullURL();
					if (empty( $wgEnableWallExt )){
						$chatter['profileType'] = 'talk-page';
						$chatter['profileTypeMsg'] = 'chat-user-menu-talk-page';
					} else {
						$chatter['profileType'] = 'message-wall';
						$chatter['profileTypeMsg'] = 'chat-user-menu-message-wall';
					}
					$chatter['profileIcon'] = DesignSystemHelper::renderSvg( 'wds-icons-reply-small', 'wds-icon wds-icon-small' );
					$chatter['contribIcon'] = DesignSystemHelper::renderSvg( 'wds-icons-pencil-small', 'wds-icon wds-icon-small' );
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
