<?php
class ChatModule extends Module {

	var $wgStylePath;
	var $wgExtensionsPath;
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

	public function executeIndex() {
		global $wgUser, $wgDevelEnvironment, $wgRequest, $wgCityId;
		wfProfileIn( __METHOD__ );
	
		// Variables for this user
		$this->username = $wgUser->getName();
		$this->avatarUrl = AvatarService::getAvatarUrl($this->username, 50);
	
		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->roomName = $this->roomTopic = "";
		$this->roomId = NodeApiClient::getDefaultRoomId($this->roomName, $this->roomTopic);

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
		$this->memberSinceStr = wfMsg('chat-member-since', "<%= since %>");

		if ($wgUser->isAllowed( 'chatmoderator' )) {
			$this->isChatMod = 1;
			$this->bodyClasses .= ' chat-mod ';
		} else {
			$this->isChatMod = 0;
		}

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		//Theme Designer stuff
		$this->themeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wgCityId );

		wfProfileOut( __METHOD__ );
	}

}
