<?php
class ChatModule extends Module {

	var $wgStylePath;
	var $wgStyleVersion;
	var $wgExtensionsPath;
	var $wgBlankImgUrl;
	var $globalVariablesScript;
	var $username;
	var $roomId;
	var $roomName;
	var $roomTopic;
	var $userList;
	var $messages;
	var $isChatMod;
	var $bodyClasses = '';
	var $themeSettings;
	var $avatarUrl;
	var $nodeHostname;
	var $nodePort;
	var $pathToProfilePage;
	var $pathToContribsPage;
	var $mainPageURL;
	var $wgFavicon = '';
	var $app;
	const CHAT_WORDMARK_WIDTH = 115;
	const CHAT_WORDMARK_HEIGHT = 30;
	const CHAT_AVATAR_DIMENSION = 41;
	public $wordmarkThumbnailUrl;
	
	public function executeIndex() {
		global $wgUser, $wgDevelEnvironment, $wgRequest, $wgCityId, $wgFavicon;
		wfProfileIn( __METHOD__ );

		$this->app = WF::build('App');
		                
		// String replacement logic taken from includes/Skin.php
		$this->wgFavicon = str_replace('images.wikia.com', 'images1.wikia.nocookie.net', $wgFavicon);
		
		$this->mainPageURL = Title::newMainPage()->getLocalURL();
		
		// add messages (fetch them using <script> tag)
		F::build('JSMessages')->enqueuePackage('Chat', JSMessages::EXTERNAL); // package defined in Chat_setup.php
		
		$this->jsMessagePackagesUrl = F::build('JSMessages')->getExternalPackagesUrl();
		// Variables for this user
		$this->username = $wgUser->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl($this->username, ChatModule::CHAT_AVATAR_DIMENSION);

		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->roomName = $this->roomTopic = "";
		$this->roomId = NodeApiClient::getDefaultRoomId($this->roomName, $this->roomTopic);
		$this->roomId = (int) $this->roomId;
		
		// Set the hostname of the node server that the page will connect to.

		$server = ChatHelper::getServer('Main');
		
		$this->nodePort = $server['port'];
		$this->nodeHostname = $server['host'];

		// Some building block for URLs that the UI needs.
		$this->pathToProfilePage = Title::makeTitle( isset($this->wg->EnableWallExt) ? NS_USER_WALL : NS_USER_TALK, '$1' )->getFullURL();
		$this->pathToContribsPage = SpecialPage::getTitleFor( 'Contributions', '$1' )->getFullURL();

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
		
		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);
	
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
	
	/**
	 * adding js variable
	 */
	
	function onMakeGlobalVariablesScript($vars) {
		global $wgLang;
		$vars['roomId'] = $this->roomId;
		$vars['wgChatMod'] = $this->isChatMod;
		$vars['WIKIA_NODE_HOST'] = $this->nodeHostname;
		$vars['WIKIA_NODE_PORT'] = $this->nodePort;
		$vars['WEB_SOCKET_SWF_LOCATION'] = $this->wgExtensionsPath.'/wikia/Chat/swf/WebSocketMainInsecure.swf?'.$this->wgStyleVersion;
		$vars['EMOTICONS'] = wfMsgForContent('emoticons');
		
		$vars['pathToProfilePage'] = $this->pathToProfilePage;
		$vars['pathToContribsPage'] = $this->pathToContribsPage;
		$vars['wgAvatarUrl'] = $this->avatarUrl;
		
		$months = array();
		for($i = 1; $i < 13; $i++ ) {
			$months[$i] =  $wgLang->getMonthAbbreviation($i);
		}
		
		$vars['wgLangtMonthAbbreviation'] = $months;

		return true;
	}
}
