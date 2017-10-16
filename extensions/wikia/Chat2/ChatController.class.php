<?php

use Wikia\Util\Assert;
use Wikia\Util\AssertionException;

class ChatController extends WikiaController {

	const CHAT_WORDMARK_WIDTH = 115;
	const CHAT_WORDMARK_HEIGHT = 30;
	const CHAT_AVATAR_DIMENSION = 41;

	/**
	 * @see SUS-2245
	 *
	 * Do not try more than given amount of re-connections. When limit is reached, reload the page.
	 */
	const SOCKET_IO_RECONNECT_MAX_TRIES = 4;

	public function executeIndex() {
		global $wgUser, $wgFavicon, $wgOut, $wgHooks, $wgWikiaBaseDomain, $wgWikiaNocookieDomain;

		wfProfileIn( __METHOD__ );

		// String replacement logic taken from includes/Skin.php
		$this->wgFavicon = str_replace( "images.{$wgWikiaBaseDomain}", "images1.{$wgWikiaNocookieDomain}", $wgFavicon );

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		// Variables for this user
		$this->username = $wgUser->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl( $this->username, ChatController::CHAT_AVATAR_DIMENSION );


		// we overwrite here data from redis since it causes a bug DAR-1532
		$pageTitle = new WikiaHtmlTitle();
		$pageTitle->setParts( [ wfMessage( 'chat' ) ] );
		$this->pageTitle = $pageTitle->getTitle();

		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->roomId = ChatServerApiClient::getPublicRoomId();
		$this->chatkey = Chat::getSessionKey();

		// SUS-2245: add assertions in Chat code
		try {
			Assert::true( is_int( $this->roomId ), 'We could not contact Chat\'s backend to get a valid roomId' );
			Assert::true( is_string( $this->chatkey ), 'We were not able to generate a valid session key for Chat' );
		} catch ( AssertionException $ex ) {
			$this->errorMsg = $ex->getMessage();
			$this->overrideTemplate( 'error' );

			// set a proper HTTP response code
			$this->getResponse()->setCode( 500 );
			return;
		}

		// Set the hostname of the node server that the page will connect to.
		$chathost = ChatConfig::getPublicHost();
		$server = explode( ":", $chathost );
		$this->chatServerHost = $server[0];
		$this->chatServerPort = $server[1];

		// Some building block for URLs that the UI needs.
		$this->pathToProfilePage = Title::makeTitle( !empty( $this->wg->EnableWallExt ) ? NS_USER_WALL : NS_USER_TALK, '$1' )->getFullURL();
		$this->pathToContribsPage = SpecialPage::getTitleFor( 'Contributions', '$1' )->getFullURL();

		$this->bodyClasses = "";
		if ( $wgUser->isAllowed( Chat::CHAT_MODERATOR ) ) {
			$this->isModerator = 1;
			$this->bodyClasses .= ' chatmoderator ';
		} else {
			$this->isModerator = 0;
		}

		// Adding chatmoderator group for other users. CSS classes added to body tag to hide/show option in menu.
		$userChangeableGroups = $wgUser->changeableGroups();
		if ( in_array( Chat::CHAT_MODERATOR, $userChangeableGroups['add'] ) ) {
			$this->bodyClasses .= ' can-give-chat-mod ';
		}

		// set up global js variables just for the chat page
		$wgHooks['MakeGlobalVariablesScript'][] = [ $this, 'onMakeGlobalVariablesScript' ];

		$wgOut->getResourceLoader()->getModule( 'mediawiki' );

		$ret = implode( "\n", [
			$wgOut->getHeadLinks( null, true ),
			$wgOut->buildCssLinks(),
			$wgOut->getHeadScripts(),
			$wgOut->getHeadItems()
		] );

		$this->globalVariablesScript = $ret;

		// Theme Designer stuff
		$themeSettingObj = new ThemeSettings();
		$themeSettings = $themeSettingObj->getSettings();
		$this->themeSettings = $themeSettings;
		$this->wordmarkThumbnailUrl = '';
		if ( $themeSettings['wordmark-type'] == 'graphic' ) {
			$title = Title::newFromText( $themeSettings['wordmark-image-name'], NS_FILE );
			if ( $title ) {
				$image = wfFindFile( $title );
				if ( $image ) {
					$this->wordmarkThumbnailUrl = $image->createThumb( self::CHAT_WORDMARK_WIDTH, self::CHAT_WORDMARK_HEIGHT );
				}
			}
			if ( empty( $this->wordmarkThumbnailUrl ) ) {
				$this->wordmarkThumbnailUrl = WikiFactory::getLocalEnvURL( $themeSettings['wordmark-image-url'] );
			}
		}

		Chat::purgeChattersCache();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * adding js variable
	 */
	public function onMakeGlobalVariablesScript( array &$vars ) {
		global $wgLang;

		$vars['wgChatKey'] = $this->chatkey;
		$vars['wgChatRoomId'] = $this->roomId;
		$vars['wgChatReconnectMaxTries'] = self::SOCKET_IO_RECONNECT_MAX_TRIES;

		$vars['wgChatHost'] = $this->chatServerHost;
		$vars['wgChatPort'] = $this->chatServerPort;
		$vars['wgChatEmoticons'] = wfMessage( 'emoticons' )->inContentLanguage()->text();

		$vars['wgChatPathToProfilePage'] = $this->pathToProfilePage;
		$vars['wgChatPathToContribsPage'] = $this->pathToContribsPage;
		$vars['wgChatMyAvatarUrl'] = $this->avatarUrl;

		$vars['wgChatLangMonthAbbreviations'] = $wgLang->getMonthAbbreviationsArray();

		return true;
	}
}
