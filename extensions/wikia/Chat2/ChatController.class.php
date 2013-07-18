<?php
class ChatController extends WikiaController {

	const CHAT_WORDMARK_WIDTH = 115;
	const CHAT_WORDMARK_HEIGHT = 30;
	const CHAT_AVATAR_DIMENSION = 41;

	public function executeIndex() {
		global $wgUser, $wgDevelEnvironment, $wgRequest, $wgCityId, $wgFavicon, $wgOut, $wgHooks;
		wfProfileIn( __METHOD__ );

		// String replacement logic taken from includes/Skin.php
		$this->wgFavicon = str_replace('images.wikia.com', 'images1.wikia.nocookie.net', $wgFavicon);

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		// add messages (fetch them using <script> tag)
		JSMessages::enqueuePackage('Chat', JSMessages::EXTERNAL); // package defined in Chat_setup.php

		$this->jsMessagePackagesUrl = JSMessages::getExternalPackagesUrl();
		// Variables for this user
		$this->username = $wgUser->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl($this->username, ChatController::CHAT_AVATAR_DIMENSION);

		// Find the chat for this wiki (or create it, if it isn't there yet).
		$roomName = $roomTopic = "";
		$this->roomId = (int) NodeApiClient::getDefaultRoomId($roomName, $roomTopic);
		$this->roomName = $roomName;
		$this->roomTopic = $roomTopic;

 		$this->chatkey = Chat::echoCookies();
		// Set the hostname of the node server that the page will connect to.

		$server = ChatHelper::getServer('Main');

		$this->nodePort = $server['port'];
		$this->nodeHostname = $server['host'];

		// Some building block for URLs that the UI needs.
		$this->pathToProfilePage = Title::makeTitle( !empty($this->wg->EnableWallExt) ? NS_USER_WALL : NS_USER_TALK, '$1' )->getFullURL();
		$this->pathToContribsPage = SpecialPage::getTitleFor( 'Contributions', '$1' )->getFullURL();

		$this->bodyClasses = "";
		if ($wgUser->isAllowed( 'chatmoderator' )) {
			$this->isChatMod = 1;
			$this->bodyClasses .= ' chat-mod ';
		} else {
			$this->isChatMod = 0;
		}

		// Adding chatmoderator group for other users. CSS classes added to body tag to hide/show option in menu.
		$userChangeableGroups = $wgUser->changeableGroups();
		if (in_array('chatmoderator', $userChangeableGroups['add'])) {
			$this->bodyClasses .= ' can-give-chat-mod ';
		}

		// set up global js variables just for the chat page
		$wgHooks['MakeGlobalVariablesScript'][] = array($this, 'onMakeGlobalVariablesScript');

		$wgOut->getResourceLoader()->getModule( 'mediawiki' );

		$ret = implode( "\n", array(
			$wgOut->getHeadLinks( null, true ),
			$wgOut->buildCssLinks(),
			$wgOut->getHeadScripts(),
			$wgOut->getHeadItems()
		) );

		$this->globalVariablesScript = $ret;

		//Theme Designer stuff
		$themeSettingObj = new ThemeSettings();
		$themeSettings = $themeSettingObj->getSettings();
		$this->themeSettings = $themeSettings;
		$this->wordmarkThumbnailUrl = '';
		if ($themeSettings['wordmark-type'] == 'graphic') {
			$title = Title::newFromText($themeSettings['wordmark-image-name'], NS_FILE);
			if ($title) {
				$image = wfFindFile($title);
				if ($image) {
					$this->wordmarkThumbnailUrl = $image->createThumb( self::CHAT_WORDMARK_WIDTH, self::CHAT_WORDMARK_HEIGHT );
				}
			}
			if ( empty( $this->wordmarkThumbnailUrl ) ) {
				$this->wordmarkThumbnailUrl = WikiFactory::getLocalEnvURL($themeSettings['wordmark-image-url']);
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * adding js variable
	 */

	function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgLang;
		$vars['roomId'] = $this->roomId;
		$vars['wgChatMod'] = $this->isChatMod;
		$vars['WIKIA_NODE_HOST'] = $this->nodeHostname;
		$vars['WIKIA_NODE_PORT'] = $this->nodePort;
		$vars['WEB_SOCKET_SWF_LOCATION'] = $this->wg->ExtensionsPath.'/wikia/Chat/swf/WebSocketMainInsecure.swf?'.$this->wg->StyleVersion;
		$vars['EMOTICONS'] = wfMsgForContent('emoticons');

		$vars['pathToProfilePage'] = $this->pathToProfilePage;
		$vars['pathToContribsPage'] = $this->pathToContribsPage;
		$vars['wgAvatarUrl'] = $this->avatarUrl;

		$vars['wgChatKey'] = $this->chatkey;

		$months = array();
		for($i = 1; $i < 13; $i++ ) {
			$months[$i] =  $wgLang->getMonthAbbreviation($i);
		}

		$vars['wgLangtMonthAbbreviation'] = $months;

		return true;
	}
}
