<?php
class ChatModule extends WikiaController {

	const CHAT_WORDMARK_WIDTH = 115;
	const CHAT_WORDMARK_HEIGHT = 30;
	const CHAT_AVATAR_DIMENSION = 41;

	public function init() {
		$this->bodyClasses = '';
	}
	
	public function executeIndex() {
		global $wgUser, $wgDevelEnvironment, $wgRequest, $wgCityId, $wgFavicon;
		wfProfileIn( __METHOD__ );

		// String replacement logic taken from includes/Skin.php
		$this->wgFavicon = str_replace('images.wikia.com', 'images1.wikia.nocookie.net', $wgFavicon);

		// add messages (fetch them using <script> tag)
		F::build('JSMessages')->enqueuePackage('Chat', JSMessages::EXTERNAL); // package defined in Chat_setup.php

		// Since we don't emit all of the JS headscripts or so, fetch the URL to load the JS Messages packages.
		$this->jsMessagePackagesUrl = F::build('JSMessages')->getExternalPackagesUrl();

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		// Variables for this user
		$this->username = $wgUser->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl($this->username, ChatModule::CHAT_AVATAR_DIMENSION);

		// Find the chat for this wiki (or create it, if it isn't there yet).
		$roomName = $roomTopic = "";
		$this->roomId = (int) NodeApiClient::getDefaultRoomId($roomName, $roomTopic);
		$this->roomName = $roomName;
		$this->roomTopic = $roomTopic;
		// Set the hostname of the node server that the page will connect to.
		$this->nodePort = NodeApiClient::PORT;
		if($wgDevelEnvironment){
			$this->nodeHostname = NodeApiClient::HOST_DEV_FROM_CLIENT;
		} else {
			$this->nodeHostname = NodeApiClient::HOST_PRODUCTION_FROM_CLIENT;
		}

		// Some building block for URLs that the UI needs.
		$this->pathToProfilePage = Title::makeTitle( NS_USER, '$1' )->getFullURL();
		$this->pathToContribsPage = SpecialPage::getTitleFor( 'Contributions', '$1' )->getFullURL();

		// Some i18n'ed strings used inside of templates by Backbone. The <%= stuffInHere % > is intentionally like
		// that & will end up in the string (substitution occurs later).
		$this->editCountStr = wfMsg('chat-edit-count', "<%= editCount %>");
		$this->memberSinceStr = "<%= since %>";

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

		$this->app->registerHook('MakeGlobalVariablesScript', 'ChatModule', 'onMakeGlobalVariablesScript', array(), false, $this);

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(WikiaApp::getSkinTemplateObj()->data);

		//Theme Designer stuff
		$themeSettings = new ThemeSettings();
		$this->themeSettings = $themeSettings->getSettings();
		$this->wordmarkThumbnailUrl = '';
		if ($this->themeSettings['wordmark-type'] == 'graphic') {
			$title = Title::newFromText($this->themeSettings['wordmark-image-name'], NS_FILE);
			if ($title) {
				$image = wfFindFile($title);
				if ($image) {
					$thumb = $image->getThumbnail(self::CHAT_WORDMARK_WIDTH, self::CHAT_WORDMARK_HEIGHT);
					if ($thumb) $this->wordmarkThumbnailUrl = $thumb->url;
				}
			}
			if (!$this->wordmarkThumbnailUrl) {
				$this->wordmarkThumbnailUrl = WikiFactory::getLocalEnvURL($this->themeSettings['wordmark-image-url']);
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/*
	 * adding js variable
	 */

	function onMakeGlobalVariablesScript($vars) {
		$vars['roomId'] = $this->roomId;
		$vars['wgChatMod'] = $this->isChatMod;
		$vars['WIKIA_NODE_HOST'] = $this->nodeHostname;
		$vars['WIKIA_NODE_PORT'] = $this->nodePort;
		$vars['WEB_SOCKET_SWF_LOCATION'] = $this->wg->ExtensionsPath.'/wikia/Chat/swf/WebSocketMainInsecure.swf';
		$vars['EMOTICONS'] = wfMsgForContent('emoticons');

		$vars['pathToProfilePage'] = $this->pathToProfilePage;
		$vars['pathToContribsPage'] = $this->pathToContribsPage;
		$vars['wgAvatarUrl'] = $this->avatarUrl;
		return true;
	}
}
