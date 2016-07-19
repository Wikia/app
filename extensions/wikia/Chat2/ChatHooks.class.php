<?php

class ChatHooks {

	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	public static function onGetRailModuleList( &$modules ) {
		wfProfileIn( __METHOD__ );

		// Make sure this module is positioned above the VideosModule (1285) when the user is logged in.  VID-1780
		$pos = F::app()->wg->User->isAnon() ? 1175 : 1286;

		// Above spotlights, below everything else. BugzId: 4597.
		$modules[$pos] = [ 'ChatRail', 'placeholder', null ];

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Prepare a pre-rendered chat entry point for logged-in users
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgUser;

		$chatUsers = [];

		if ( $wgUser->isLoggedIn() ) {
			$chatUsers = ChatWidget::getUsersInfo();

			if ( empty( $chatUsers ) ) {
				// we will need it to attract user to join chat
				$vars['wgWikiaChatProfileAvatarUrl'] = AvatarService::getAvatarUrl( $wgUser->getName(), ChatRailController::AVATAR_SIZE );
			}
		}

		$vars['wgWikiaChatUsers'] = $chatUsers;
		$vars['wgWikiaChatWindowFeatures'] = ChatRailController::CHAT_WINDOW_FEATURES;

		return true;
	}

	/**
	 * Add WikiaChatLink to all Chat links (we open them in new window in JS)
	 */
	public static function onLinkEnd( $skin, Title $target, array $options, &$text, array &$attribs, &$ret ) {
		if ( $target->isSpecial( 'Chat' ) && $target->isLocal() ) {
			if ( !array_key_exists( 'class', $attribs ) ) {
				$attribs['class'] = 'WikiaChatLink';
			} else {
				$attribs['class'] .= ' WikiaChatLink';
			}
		}

		return true;
	}

	/**
	 * Hook: BeforePageDisplay
	 * Add resources needed by the chat ban modal to pages where it can appear
	 * (Special:Contributions, Special:Log, and Special:RecentChanges)
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return true to continue hook processing
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		wfProfileIn( __METHOD__ );

		$specialPages = [
			'Contributions',
			'Log',
			'Recentchanges'
		];

		foreach ( $specialPages as $value ) {
			if ( $out->getTitle()->isSpecial( $value ) ) {
				$out->addModules( 'ext.Chat2.ChatBanModal' );
				$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Chat2/css/ChatModal.scss' ) );
				break;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgOut, $wgUser;
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $id );
		if ( !empty( $user ) ) {
			$tools[] = Linker::link( SpecialPage::getSafeTitleFor( 'Log', 'chatban' ), wfMessage( 'chat-chatban-log' )->escaped(), [ 'class' => 'chat-ban-log' ], [ 'page' => $user->getUserPage()->getPrefixedText() ] ); # Add chat ban log link (@author: Sactage)
			$chatUser = new ChatUser( $user );
			if ( $chatUser->isBanned() ) {
				LogEventsList::showLogExtract(
					$wgOut,
					'chatban',
					$nt->getPrefixedText(),
					'',
					[
						'lim' => 1,
						'showIfEmpty' => false,
						'msgKey' => [
							'chat-contributions-ban-notice',
							# Support GENDER in 'sp-contributions-blocked-notice'
							$nt->getText()
						],
						# don't use $wgRequest parameter offset
						'offset' => ''
					]
				);
			} else {
				if ( $wgUser->isAllowed( Chat::CHAT_MODERATOR ) && !$user->isAllowed( Chat::CHAT_MODERATOR ) ) {
					$tools[] = "<a class='chat-change-ban' data-user-id='{$id}' href='#'>" . wfMessage( 'chat-ban-contributions-heading' )->escaped() . "</a>";
				}
			}
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	public static function onLogLine( $logType, $logaction, $title, $paramArray, &$comment, &$revert, $logTimestamp ) {
		global $wgUser;

		if ( strpos( $logaction, 'chatban' ) === 0 ) {
			$user = User::newFromId( $paramArray[1] );
			if ( !empty( $user ) ) {
				$chatUser = new ChatUser( $user );
				if ( $chatUser->isBanned() && $wgUser->isAllowed( Chat::CHAT_MODERATOR ) ) {
					$revert = "(" . "<a class='chat-change-ban' data-user-id='{$paramArray[1]}' href='#'>" . wfMessage( 'chat-ban-log-change-ban-link' )->escaped() . "</a>" . ")";
				}
			}
		} elseif ( $logaction === 'chatconnect' && !empty( $paramArray ) ) {
			$ipLinks = [ ];
			if ( $wgUser->isAllowed( 'multilookup' ) ) {
				$mlTitle = GlobalTitle::newFromText( 'MultiLookup', NS_SPECIAL, 177 );
				// Need to make the link manually for this as Linker's normaliseSpecialPage
				// makes the link local if the special page exists locally, rather than
				// keeping the global title
				$ipLinks[] = Xml::tags(
					'a',
					[ 'href' => $mlTitle->getFullURL( 'target=' . urlencode( $paramArray[0] ) ) ],
					wfMessage( 'multilookup' )->escaped()
				);
				$ipLinks[] = Linker::makeKnownLinkObj(
					GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, 177 ),
					wfMessage( 'phalanx' )->escaped(),
					wfArrayToCGI( [ 'type' => '8', 'target' => $paramArray[0], 'wpPhalanxCheckBlocker' => $paramArray[0] ] )
				);
				$ipLinks[] = Linker::blockLink( 0, $paramArray[0] );
				$revert = '(' . implode( wfMessage( 'pipe-separator' )->plain(), $ipLinks ) . ')';
			}
		}

		return true;
	}

	public static function formatLogEntry( $type, $action, $title, $forUI, $params, $filterWikilinks ) {
		global $wgLang;

		if ( empty( $params[0] ) ) {
			return "";
		}

		$endOnText = "";
		if ( !empty( $params[3] ) ) {
			$endOnText = $wgLang->timeanddate( wfTimestamp( TS_MW, $params[3] ), true );
		}

		$skin = RequestContext::getMain()->getSkin();
		$id = $params[1];
		if ( !$filterWikilinks ) { // Plaintext? Used for IRC messages (BugID: 44249)
			$targetUser = User::newFromId( $id );
			$link = "[[User:{$targetUser->getName()}]]";
		} else {
			$link = $skin->userLink( $id, $title->getText() )
				. $skin->userToolLinks( $id, $title->getText(), false );
		}

		$time = "";
		if ( !empty( $params[2] ) ) {
			$time = $params[2];
		}

		return wfMessage( 'chat-' . $action . '-log-entry', $link, $time, $endOnText )->text();
	}

	/**
	 * Add read right to ChatAjax am reqest.
	 * That is solving problems with private wikis and chat (communitycouncil.wikia.com)
	 */
	public static function onUserGetRights( $user, &$aRights ) {
		global $wgRequest;
		if ( $wgRequest->getVal( 'action' ) === 'ajax' && $wgRequest->getVal( 'rs' ) === 'ChatAjax' ) {
			$aRights[] = 'read';
		}

		return true;
	}
}
