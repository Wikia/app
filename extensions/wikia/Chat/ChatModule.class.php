<?php
class ChatModule extends Module {

	var $wgStylePath;
	var $wgExtensionsPath;
	var $globalVariablesScript;
	var $roomId;
	var $roomName;
	var $roomTopic;
	var $userList;
	var $messages;
	var $isChatMod;
	var $bodyClasses = '';

	public function executeIndex() {
		global $wgUser, $wgDevelEnvironment, $wgRequest;
		wfProfileIn( __METHOD__ );
	
		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->roomName = $this->roomTopic = "";
		$this->roomId = NodeApiClient::getDefaultRoomId($this->roomName, $this->roomTopic);
		
		// Set the hostname of the node server that the page will connect to.
		if($wgDevelEnvironment){
			$this->nodeHostname = NodeApiClient::HOST_DEV;
			if($wgRequest->getVal('prod') == "1"){
				$this->nodeHostname = NodeApiClient::HOST_PRODUCTION;
				$this->bodyClasses .= ' on-prod '; // visually warn the user that they're connecting to the prod node server.

				// TODO: FIXME: Since the node api requests are mostly from the server, it needs to know to append "&prod=1" to its ajax requests, otherwise it will try to use two diff redis instances.
				// Also change where the NodeApiClient will try to connect to.
				global $wgNodeHostAndPort;
				$wgNodeHostAndPort = NodeApiClient::HOST_AND_PORT_PRODUCTION;
 			}
		} else {
			$this->nodeHostname = NodeApiClient::HOST_PRODUCTION;
		}

		if ($wgUser->isAllowed( 'chatmoderator' )) {
			$this->isChatMod = 1;
			$this->bodyClasses .= ' chat-mod ';
		} else {
			$this->isChatMod = 0;
		}

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		wfProfileOut( __METHOD__ );
	}

}
