<?php
/**
 * @author Jacek "mech" Wozniak <mech@wikia-inc.com>
 *
 * ChatEntryPoint object implementation
 */
class ChatEntryPoint {

	/**
	 * TTL for chat users list. This cache is purged when a new user joins the chat, but we don't purge it when
	 * user leaves chat. That's why this cache time is pretty short
	 */
	const CHAT_USER_LIST_CACHE = 60;
	const RIGHT_RAIL_MODULE_CLASS = 'module';
	const PARSER_TAG_CLASS = 'ChatEntryPoint';

	/**
	 * @brief This function set parseTag hook
	 */
	static public function onParserFirstCallInit( Parser &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( CHAT_TAG, array( __CLASS__, "parseTag" ) );
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
	static public function getEntryPointTemplateVars( $fromParserTag ) {
		global $wgEnableWallExt, $wgBlankImgUrl, $wgUser, $wgSitename;

		$entryPointGuidelinesMessage = wfMessage( 'chat-entry-point-guidelines' );
		$joinTheChatMessage = wfMessage( 'chat-join-the-chat' );
		$chatUsersInfo = ChatEntryPoint::getChatUsersInfo();
		$chatProfileAvatarUrl = AvatarService::getAvatarUrl( $wgUser->getName(), ChatRailController::AVATAR_SIZE );

		$vars =  [
			'blankImgUrl' => $wgBlankImgUrl,
			'chatUsers' => $chatUsersInfo,
			'chatUsersCount' => count( $chatUsersInfo ),
			'entryPointGuidelinesMessage' => $entryPointGuidelinesMessage->exists() ?
				$entryPointGuidelinesMessage->text() : null,
			'fromParserTag' => $fromParserTag,
			'sectionClassName' => $fromParserTag ? self::PARSER_TAG_CLASS : self::RIGHT_RAIL_MODULE_CLASS,
			'joinTheChatMessage' => $joinTheChatMessage->exists() ?
				$joinTheChatMessage->text() : null,
			'linkToSpecialChat' => SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl(),
			'siteName' => $wgSitename,
			'profileType' => empty( $wgEnableWallExt ) ? 'talk-page' : 'message-wall',
			'userName' => $wgUser->isAnon() ? null : $wgUser->getName(),
		];

		if ( empty( $chatUsersInfo ) ) {
			$vars[ 'chatProfileAvatarUrl' ] = $chatProfileAvatarUrl;
		}

		return $vars;
	}

	/**
	 * Chat tag parser implementation.
	 * Return html of a chat wrapped in nowiki tags.
	 */
	static public function parseTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix(__DIR__ . '/templates');

		$html = $templateEngine->clearData()
			->setData(  self::getEntryPointTemplateVars( true ) )
			->render( self::getChatTemplateName() );

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
	static public function getChatTemplateName() {

		return F::app()->checkSkin( 'oasis' ) ?
			'entryPointTag.mustache' :
			'entryPointTagMonobook.mustache';
	}

	static private function getChatUsersMemcKey() {
		return wfMemcKey( 'chatusersinfo' );
	}

	static public function purgeChatUsersCache() {
		WikiaDataAccess::cachePurge( self::getChatUsersMemcKey() );
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
	static public function getChatUsersInfo() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgReadOnly;
		wfProfileIn( __METHOD__ );
		$chatters = [];
		if ( empty( $wgReadOnly ) ) {
			// cache the whole response
			// individual users are cached anyway, but still we gain performance making just one memcache request instead of several
			$chatters = WikiaDataAccess::cache( self::getChatUsersMemcKey(), ChatEntryPoint::CHAT_USER_LIST_CACHE, function() {
				global $wgEnableWallExt, $wgLang;
				$chatters = [];
				// Gets array of users currently in chat to populate rail module and user stats menus
				$chattersIn = NodeApiClient::getChatters();

				foreach ( $chattersIn as $i => $val ) {
					$chatters[ $i ] = WikiaDataAccess::cache( wfMemcKey( 'chatavatars', $val, 'v2' ), 60 * 60, function() use ( $wgEnableWallExt, $wgLang, $val ) {
						$chatter = [
							'username' => $val,
							'avatarUrl' => AvatarService::getAvatarUrl( $val, ChatRailController::AVATAR_SIZE )
						];

						// get stats for edit count and member since
						$user = User::newFromName( $val );

						if ( $user instanceof User ) {
							$userStatsService = new UserStatsService( $user->getId() );
							$stats = $userStatsService->getStats();

							// edit count
							$chatter[ 'editCount' ] = $stats[ 'edits' ];

							// member since
							$chatter[ 'showSince' ] = $chatter[ 'editCount' ] != 0;
							if ( $chatter[ 'showSince' ] ) {
								$months = $wgLang->getMonthAbbreviationsArray();
								$date = getdate( strtotime( $stats[ 'date' ] ) );

								$chatter[ 'since_year' ] = $date[ 'year' ];
								$chatter[ 'since_month' ] =  $date[ 'mon' ];
								$chatter[ 'since' ] = sprintf( '%s %s', $months[ $chatter[ 'since_month' ] ] , $chatter[ 'since_year' ] );
							}

							$profileUrlNs = !empty( $wgEnableWallExt ) ? NS_USER_WALL : NS_USER_TALK;
							$chatter[ 'profileUrl' ] = Title::makeTitle( $profileUrlNs, $chatter[ 'username' ] )->getFullURL();
							$chatter[ 'contribsUrl' ] = SpecialPage::getTitleFor( 'Contributions', $chatter[ 'username' ] )->getFullURL();
						}
						return $chatter;
					} );
				}
				return $chatters;
			} );
		}
		wfProfileOut( __METHOD__ );
		return $chatters;
	}
}
