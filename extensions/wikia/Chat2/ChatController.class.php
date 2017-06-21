<?php

use Wikia\Util\GlobalStateWrapper;

class ChatController extends WikiaController {

	const CHAT_WORDMARK_WIDTH = 115;
	const CHAT_WORDMARK_HEIGHT = 30;
	const CHAT_AVATAR_DIMENSION = 41;

	public function executeIndex() {
		global $wgFavicon, $wgHooks, $wgWikiaBaseDomain, $wgWikiaNocookieDomain;

		Chat::info( __METHOD__ . ': Method called' );

		wfProfileIn( __METHOD__ );

		$user = $this->getContext()->getUser();

		// String replacement logic taken from includes/Skin.php
		$this->wgFavicon = str_replace( "images.{$wgWikiaBaseDomain}", "images1.{$wgWikiaNocookieDomain}", $wgFavicon );

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		// Variables for this user
		$this->username = $user->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl( $this->username, ChatController::CHAT_AVATAR_DIMENSION );

		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->roomId = ChatServerApiClient::getPublicRoomId();

		// we overwrite here data from redis since it causes a bug DAR-1532
		$pageTitle = new WikiaHtmlTitle();
		$pageTitle->setParts( [ wfMessage( 'chat' ) ] );
		$this->pageTitle = $pageTitle->getTitle();

		$this->chatkey = Chat::getSessionKey();

		// Set the hostname of the node server that the page will connect to.
		$chathost = ChatConfig::getPublicHost();
		$server = explode( ":", $chathost );
		$this->chatServerHost = $server[0];
		$this->chatServerPort = $server[1];

		// Some building block for URLs that the UI needs.
		$this->pathToProfilePage = Title::makeTitle( !empty( $this->wg->EnableWallExt ) ? NS_USER_WALL : NS_USER_TALK, '$1' )->getFullURL();
		$this->pathToContribsPage = SpecialPage::getTitleFor( 'Contributions', '$1' )->getFullURL();

		$this->bodyClasses = "";
		if ( $user->isAllowed( Chat::CHAT_MODERATOR ) ) {
			$this->isModerator = 1;
			$this->bodyClasses .= ' chatmoderator ';
		} else {
			$this->isModerator = 0;
		}

		// Adding chatmoderator group for other users. CSS classes added to body tag to hide/show option in menu.
		$userChangeableGroups = $user->changeableGroups();
		if ( in_array( Chat::CHAT_MODERATOR, $userChangeableGroups['add'] ) ) {
			$this->bodyClasses .= ' can-give-chat-mod ';
		}

		// set up global js variables just for the chat page
		$wgHooks['MakeGlobalVariablesScript'][] = [ $this, 'onMakeGlobalVariablesScript' ];

		// SUS-2198: Start with a fresh OutputPage and discard any unneeded modules set by hooks.
		$out = new OutputPage( $this->getContext() );
		$out->topScripts = $this->getContext()->getOutput()->topScripts;

		$ret = implode( "\n", [
			$out->getHeadLinks( null, true ),
			$out->buildCssLinks(),
			$out->getHeadScripts(),
			$out->getHeadItems()
		] );

		$this->globalVariablesScript = $ret;

		// Load core chat frontend
		// emitting <script> makes sure that ext.Chat2 loads before site/user CSS&JS
		$out->addModuleScripts( 'ext.Chat2' );

		$this->addSiteJsCss( $out );
		$this->addUserJsCss( $out );

		// SUS-2198: Wrap invocation of OutputPage::getBottomScripts
		// Otherwise, normal site and user JS/CSS is loaded when that stuff should not be in chat.
		$wrapper = new GlobalStateWrapper( [
			'wgUseSiteJs' => false,
			'wgUseSiteCss' => false,
			'wgAllowUserJs' => false,
			'wgAllowUserCss' => false,
		] );

		$wrapper->wrap( function () use ( $out ) {
			$this->bottomScripts = $out->getBottomScripts();
		} );

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
	 * Add MediaWiki:Chat.js and MediaWiki:Chat.css to output, respecting configuration
	 * @param OutputPage $out
	 */
	private function addSiteJsCss( OutputPage $out ) {
		switch ( true ) {
			case ( $this->wg->UseSiteJs && $this->wg->UseSiteCss ):
				$out->addModules( 'chat.site' );
				break;
			case $this->wg->UseSiteJs:
				$out->addModuleScripts( 'chat.site' );
				break;
			case $this->wg->UseSiteCss:
				$out->addModuleStyles( 'chat.site' );
				break;
			default:
		}
	}

	/**
	 * Add User:UserName/chat.js and User:UserName/chat.css to output, respecting configuration
	 * @param OutputPage $out
	 */
	private function addUserJsCss( OutputPage $out ) {
		switch ( true ) {
			case ( $this->wg->AllowUserJs && $this->wg->AllowUserCss ):
				$out->addModules( 'chat.user' );
				break;
			case $this->wg->AllowUserJs:
				$out->addModuleScripts( 'chat.user' );
				break;
			case $this->wg->AllowUserCss:
				$out->addModuleStyles( 'chat.user' );
				break;
			default:
		}
	}

	/**
	 * adding js variable
	 */
	public function onMakeGlobalVariablesScript( array &$vars ) {
		global $wgLang;

		$vars['wgChatKey'] = $this->chatkey;
		$vars['wgChatRoomId'] = $this->roomId;

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
