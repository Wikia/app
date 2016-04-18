<?php

use Wikia\Logger\WikiaLogger;

class ChatHelper {
	// constants with config file sections
	const CHAT_DEVBOX_ENV = 'dev';
	const CHAT_PREVIEW_ENV = 'preview';
	const CHAT_VERIFY_ENV = 'verify';
	const CHAT_PRODUCTION_ENV = 'prod';

	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList( &$modules ) {
		wfProfileIn( __METHOD__ );

		// Make sure this module is positioned above the VideosModule (1285) when the user is logged in.  VID-1780
		$pos = F::app()->wg->User->isAnon() ? 1175 : 1286;

		// Above spotlights, below everything else. BugzId: 4597.
		$modules[$pos] = array( 'ChatRail', 'placeholder', null );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param string $type
	 * @return array
	 */
	static public function getServer( $type = 'public' ) {
		global $wgCityId;

		// TODO: make it always random
		$serverNodes = self::getServerNodes( $type );
		$serversCount = count( $serverNodes );
		$serverIndex = $wgCityId % $serversCount;
		$serverId = $serverIndex + 1;
		$serverData = $serverNodes[ $serverIndex ];

		return [
			'serverIp' => $serverData,
			'serverId' => $serverId
		];
	}

	/**
	 * @param string $type
	 * @return array
	 */
	static function getServerNodes( $type = 'public' ) {
		global $wgWikiaEnvironment;

		$consul = new Wikia\Consul\Client();

		if ( $wgWikiaEnvironment !== self::CHAT_DEVBOX_ENV ) {
			$serverNodes = $consul->getNodes( 'chat-' . $type, $wgWikiaEnvironment );
		} else {
			// TODO: do not hardcode devbox name here!
			$serverNodes = $type === 'private' ? [ "dev-diana:8081" ] : [ "dev-diana:8080" ];
		}

		return $serverNodes;
	}

	static function getChatHost() {
		global $wgChatHost, $wgWikiaEnvironment;

		// TODO: do not hardcode devbox name here!
		$chatHost = $wgWikiaEnvironment === self::CHAT_DEVBOX_ENV ? "dev-diana:8080" : $wgChatHost;

		return $chatHost;
	}

	/**
	 * Prepare a pre-rendered chat entry point for logged-in users
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgUser, $wgLang;
		if ( $wgUser->isLoggedIn() ) {
			$vars[ 'wgWikiaChatUsers' ] = ChatEntryPoint::getChatUsersInfo();
			if ( empty( $vars[ 'wgWikiaChatUsers' ] ) ) {
				// we will need it to attract user to join chat
				$vars[ 'wgWikiaChatProfileAvatarUrl' ] = AvatarService::getAvatarUrl( $wgUser->getName(), ChatRailController::AVATAR_SIZE );
			}
			$vars['wgWikiaChatMonts'] = $wgLang->getMonthAbbreviationsArray();
		} else {
			$vars[ 'wgWikiaChatUsers' ] = '';
		}
		$vars[ 'wgWikiaChatWindowFeatures' ] = ChatRailController::CHAT_WINDOW_FEATURES;

		return true;
	}

	/**
	 * Add WikiaChatLink to all Chat links (we open them in new window in JS)
	 */
	public static function onLinkEnd( $skin, Title $target, array $options, &$text, array &$attribs, &$ret ) {
		if ( ( $target instanceof Title ) && ( $target->getNamespace() == NS_SPECIAL ) && $target->isLocal() && ( $target->getText() == "Chat" ) ) {
			if ( !array_key_exists( 'class', $attribs ) ) $attribs['class'] = 'WikiaChatLink';
			else $attribs['class'] .= ' WikiaChatLink';
		}
		return true;
	}

	/**
	 * add resources needed by chat
	 * as chat entry points or links can appear on any page,
	 * we really need them everywhere
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $wgExtensionsPath, $wgTitle, $wgResourceBasePath;

		wfProfileIn( __METHOD__ );

		$sp = array(
			'Contributions',
			'Log',
			'Recentchanges'
		);

		foreach ( $sp as $value ) {
			if ( $wgTitle->isSpecial( $value ) ) {
				// For Chat2 (doesn't exist in Chat(1))
				$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'chat_ban_js', array() );

				foreach ( $srcs as $val ) {
					$out->addScript( '<script src="' . $val . '"></script>' );
				}
				JSMessages::enqueuePackage( 'ChatBanModal', JSMessages::EXTERNAL );
				$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Chat2/css/ChatModal.scss' ) );
				break;
			}
		}
		JSMessages::enqueuePackage( 'ChatEntryPoint', JSMessages::INLINE );

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgOut, $wgUser, $wgCityId;
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $id );
		if ( !empty( $user ) ) {
			$tools[] = Linker::link( SpecialPage::getSafeTitleFor( 'Log', 'chatban' ), wfMessage( 'chat-chatban-log' )->escaped(), array( 'class' => 'chat-ban-log' ), array( 'page' => $user->getUserPage()->getPrefixedText() ) ); # Add chat ban log link (@author: Sactage)
			if ( Chat::getBanInformation( $wgCityId, $user ) !== false ) {
				$dir = "change";
				LogEventsList::showLogExtract(
					$wgOut,
					'chatban',
					$nt->getPrefixedText(),
					'',
					array(
						'lim' => 1,
						'showIfEmpty' => false,
						'msgKey' => array(
							'chat-contributions-ban-notice',
							$nt->getText() # Support GENDER in 'sp-contributions-blocked-notice'
						),
						'offset' => '' # don't use $wgRequest parameter offset
					)
				);
			} else {
				if ( $wgUser->isAllowed( 'chatmoderator' ) && !$user->isAllowed( 'chatmoderator' )  ) {
					$tools[] =  "<a class='chat-change-ban' data-user-id='{$id}' href='#'>" . wfMsg( 'chat-ban-contributions-heading' ) . "</a>" ;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onLogLine( $logType, $logaction, $title, $paramArray, &$comment, &$revert, $logTimestamp ) {
		global $wgUser, $wgCityId;

		if ( strpos( $logaction, 'chatban' ) === 0 ) {
			$user = User::newFromId( $paramArray[1] );
			if ( !empty( $user ) && Chat::getBanInformation( $wgCityId, $user ) !== false && $wgUser->isAllowed( 'chatmoderator' ) ) {
				$revert = "(" . "<a class='chat-change-ban' data-user-id='{$paramArray[1]}' href='#'>" . wfMsg( 'chat-ban-log-change-ban-link' ) . "</a>" . ")";
			}
		} elseif ( $logaction === 'chatconnect'  && !empty( $paramArray ) ) {
			$ipLinks = array();
			if ( $wgUser->isAllowed( 'multilookup' ) ) {
				$mlTitle = GlobalTitle::newFromText( 'MultiLookup', NS_SPECIAL, 177 );
				// Need to make the link manually for this as Linker's normaliseSpecialPage
				// makes the link local if the special page exists locally, rather than
				// keeping the global title
				$ipLinks[] = Xml::tags(
					'a',
					array( 'href' => $mlTitle->getFullURL( 'target=' . urlencode( $paramArray[0] ) ) ),
					wfMessage( 'multilookup' )->escaped()
				);
				$ipLinks[] = Linker::makeKnownLinkObj(
					GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, 177 ),
					wfMessage( 'phalanx' )->escaped(),
					wfArrayToCGI( array( 'type' => '8', 'target' => $paramArray[0], 'wpPhalanxCheckBlocker' => $paramArray[0] ) )
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

		$endon = "";
		if ( !empty( $params[3] ) ) {
			$endon = $wgLang->timeanddate( wfTimestamp( TS_MW, $params[3] ), true );
		}

		$skin = RequestContext::getMain()->getSkin();
		$id =  $params[1];

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

		return wfMsg( 'chat-' . $action . '-log-entry', $link, $time, $endon );
	}

	static public function info( $message, Array $params = [] ) {
		WikiaLogger::instance()->info( 'CHAT: ' . $message, $params );
	}

	static public function debug( $message, Array $params = [] ) {
		WikiaLogger::instance()->debug( 'CHAT: ' . $message, $params );
	}
}
